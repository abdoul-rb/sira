<?php

use App\Models\Company;

it('can resolve company by slug using route model binding', function () {
    // Créer une company de test
    $company = Company::factory()->create([
        'name' => 'Test Company',
        'active' => true,
    ]);

    // Vérifier que le slug a été généré
    expect($company->slug)->toBe('test-company');

    // Debug: afficher les routes disponibles
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'dashboard')) {
            dump([
                'uri' => $route->uri(),
                'domain' => $route->getDomain(),
                'methods' => $route->methods(),
            ]);
        }
    }

    // Tester que la route peut résoudre la company
    $response = $this->get("http://{$company->slug}.localhost/dashboard");
    
    // Debug: afficher la réponse
    dump([
        'status' => $response->status(),
        'content' => $response->content(),
    ]);
    
    // La réponse devrait contenir les données de la company
    $response->assertStatus(200);
});

it('returns 404 for non-existent company slug', function () {
    $response = $this->get('http://non-existent-company.localhost/dashboard');
    
    $response->assertStatus(404);
});

it('can access company data in controller', function () {
    $company = Company::factory()->create([
        'name' => 'Another Company',
        'active' => true,
    ]);

    // Simuler une requête vers le dashboard
    $response = $this->get("http://{$company->slug}.sira.test/dashboard");
    
    // Le contrôleur devrait recevoir l'objet Company complet
    $response->assertStatus(200);
}); 