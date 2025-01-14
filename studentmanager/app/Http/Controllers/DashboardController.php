<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\View\View;
use App\Services\FakeStore\FakeStoreService;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    const ROLES = ['ROLE_STUDENT', 'ROLE_MENTOR', 'ROLE_PARENT', 'ROLE_ADMIN'];

    public function __invoke(Request $request): View
    {
        $fakestore = app(FakeStoreService::class);
        $products = $fakestore->products();
        $code = <<<EOD
         <?php

namespace App\Services\FakeStore;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Services\FakeStore\DataTransferObjects\ProductData;

class FakeStoreService
{
    public function __construct()
    {
    }
    /**
     * Summary of products
     * @return \Illuminate\Support\Collection<ProductData>
     */
    public function products(): Collection
    {
        \$products = Http::get("/api/products")->json();

        return collect(\$products)
            ->map(fn(array \$data) => ProductData::fromArray(\$data));
    }
}
EOD;

        $displayRoles = $request->user()->roles->filter(function (Role $role) {
            return in_array($role->name, DashboardController::ROLES);
        })->map(function (Role $role) {
            return __($role->name);
        })->implode(', ');
        $test = Http::post("http://localhost:11434/api/generate", [
            'model' => 'llama3.2',
            'prompt' => 'Can you analyse the following php code: \n' . $code,
            'stream' => false,
        ]);
        dump($test->body());
        $response = $test->json();
        dump($response['response']);
        $rarray = json_decode($response['response']);
        dd($rarray);

        return view('dashboard', [
            'user' => $request->user(),
            'roles' => $displayRoles,
            'studentclasses' => $request->user()->classrooms,
            'mentorclasses' => $request->user()->mentorOf,
            'children' => $request->user()->children,
        ]);
    }
}
