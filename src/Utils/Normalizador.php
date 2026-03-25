<?php

namespace App\Utils;

class Normalizador 
{
    /**
     * Torna uma string minúscula, sem acentos e apenas com caracteres alfanuméricos.
     * 
     * Função crucial para garantir a consistência ao cadastrar e editar cursos,
     * por conta do relacionamento com categorias e plataformas.
     * (ex: Programação Back-End e programacao back end devem cair na mesma categoria)
     */
    public static function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower($texto); // lowercase
        
        // tirar os acentos
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); 

        // regex simples para manter apenas alfanuméricos
        $texto = preg_replace('/[^a-z0-9]/', '', $texto); 

        return $texto;
    }
}