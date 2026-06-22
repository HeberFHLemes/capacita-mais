import { Component, inject, OnInit } from '@angular/core';
import { Categoria } from '../../../categorias/models/categoria';
import { HttpErrorResponse } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { CategoriaRow } from '../../components/categoria-row/categoria-row';
import { AdminCategoriasApiService } from '../../services/admin-categorias-api-service';
import { Alerta } from '../../../../shared/components/alerta/alerta';

@Component({
  selector: 'app-gestao-categorias-page',
  standalone: true,
  imports: [RouterLink, CategoriaRow, Alerta],
  templateUrl: './gestao-categorias-page.html',
  styleUrl: './gestao-categorias-page.css',
})
export class GestaoCategoriasPage implements OnInit {

  private readonly apiService: AdminCategoriasApiService = inject(AdminCategoriasApiService);

  categorias: Categoria[] = [];

  // feedback de erro ao tentar remover uma categoria
  erroRemocao: string | null = null;

  ngOnInit() {
    this.carregarCategorias();
  }

  carregarCategorias() {
    this.apiService.buscarCategorias()
      .subscribe((resposta) => this.categorias = resposta);
  }

  remover(categoriaId: number) {
    this.erroRemocao = null;

    this.apiService.removerCategoria(categoriaId)
      .subscribe({
        next: () => {
          this.categorias = this.categorias.filter(c => c.id !== categoriaId);
        },
        error: (err: HttpErrorResponse) => {
          this.erroRemocao = err.status === 404
            ? 'Esta categoria já não existe mais. Atualize a página.'
            : 'Não foi possível remover a categoria. Tente novamente.';
        }
      });
  }
}
