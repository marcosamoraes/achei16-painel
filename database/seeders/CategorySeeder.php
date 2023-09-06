<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate(['name' => 'Academia'], ['name' => 'Academia']);
        Category::updateOrCreate(['name' => 'Agropecuaria e Agrícolas'], ['name' => 'Agropecuaria e Agrícolas']);
        Category::updateOrCreate(['name' => 'Alimentos'], ['name' => 'Alimentos']);
        Category::updateOrCreate(['name' => 'Aluguel de Trajes'], ['name' => 'Aluguel de Trajes']);
        Category::updateOrCreate(['name' => 'Antenas e Banca de Jornal'], ['name' => 'Antenas e Banca de Jornal']);
        Category::updateOrCreate(['name' => 'Ar Condicionado e Refrigeração'], ['name' => 'Ar Condicionado e Refrigeração']);
        Category::updateOrCreate(['name' => 'Artesanato'], ['name' => 'Artesanato']);
        Category::updateOrCreate(['name' => 'Artigo para Pesca'], ['name' => 'Artigo para Pesca']);
        Category::updateOrCreate(['name' => 'Auto Escola e Transportadora'], ['name' => 'Auto Escola e Transportadora']);
        Category::updateOrCreate(['name' => 'Água e Gás'], ['name' => 'Água e Gás']);
        Category::updateOrCreate(['name' => 'Óticas e Imobiliárias'], ['name' => 'Óticas e Imobiliárias']);
        Category::updateOrCreate(['name' => 'Bebedouros'], ['name' => 'Bebedouros']);
        Category::updateOrCreate(['name' => 'Beleza e Estética'], ['name' => 'Beleza e Estética']);
        Category::updateOrCreate(['name' => 'Bicicleta e Jogos'], ['name' => 'Bicicleta e Jogos']);
        Category::updateOrCreate(['name' => 'Brinquedos'], ['name' => 'Brinquedos']);
        Category::updateOrCreate(['name' => 'Celulares'], ['name' => 'Celulares']);
        Category::updateOrCreate(['name' => 'Chaveiro'], ['name' => 'Chaveiro']);
        Category::updateOrCreate(['name' => 'Chácaras e Escritorio'], ['name' => 'Chácaras e Escritorio']);
        Category::updateOrCreate(['name' => 'Churrasqueiras'], ['name' => 'Churrasqueiras']);
        Category::updateOrCreate(['name' => 'Clínicas e Consultórios'], ['name' => 'Clínicas e Consultórios']);
        Category::updateOrCreate(['name' => 'Comunicação Visual'], ['name' => 'Comunicação Visual']);
        Category::updateOrCreate(['name' => 'Confecções'], ['name' => 'Confecções']);
        Category::updateOrCreate(['name' => 'Consultorio Veterinario'], ['name' => 'Consultorio Veterinario']);
        Category::updateOrCreate(['name' => 'Cosmético'], ['name' => 'Cosmético']);
        Category::updateOrCreate(['name' => 'Cosmético e Perfumaria'], ['name' => 'Cosmético e Perfumaria']);
        Category::updateOrCreate(['name' => 'Cursos'], ['name' => 'Cursos']);
        Category::updateOrCreate(['name' => 'Despachante'], ['name' => 'Despachante']);
        Category::updateOrCreate(['name' => 'Eletrônico e Games'], ['name' => 'Eletrônico e Games']);
        Category::updateOrCreate(['name' => 'Empresa'], ['name' => 'Empresa']);
        Category::updateOrCreate(['name' => 'Farmácia'], ['name' => 'Farmácia']);
        Category::updateOrCreate(['name' => 'Ferramentaria e Borrachas'], ['name' => 'Ferramentaria e Borrachas']);
        Category::updateOrCreate(['name' => 'Festa'], ['name' => 'Festa']);
        Category::updateOrCreate(['name' => 'Financeira'], ['name' => 'Financeira']);
        Category::updateOrCreate(['name' => 'Floricultura'], ['name' => 'Floricultura']);
        Category::updateOrCreate(['name' => 'Formaturas'], ['name' => 'Formaturas']);
        Category::updateOrCreate(['name' => 'Fotos e Filmagens'], ['name' => 'Fotos e Filmagens']);
        Category::updateOrCreate(['name' => 'Frios'], ['name' => 'Frios']);
        Category::updateOrCreate(['name' => 'Gráfica'], ['name' => 'Gráfica']);
        Category::updateOrCreate(['name' => 'Hotel'], ['name' => 'Hotel']);
    }
}
