import { Component, inject, OnInit } from '@angular/core';
import { Categoria } from '../../../categorias/models/categoria';
import { HttpErrorResponse } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { CategoriaRow } from '../../components/categoria-row/categoria-row';
import { AdminCategoriasApiService } from '../../services/admin-categorias-api-service';

@Component({
  selector: 'app-gestao-categorias-page',
  standalone: true,
  imports: [RouterLink, CategoriaRow],
  templateUrl: './gestao-categorias-page.html',
  styleUrl: './gestao-categorias-page.css',
})
export class GestaoCategoriasPage implements OnInit {

  private readonly apiService: AdminCategoriasApiService = inject(AdminCategoriasApiService);

  categorias: Categoria[] = [];

  ngOnInit() {
    this.carregarCategorias();
  }

  carregarCategorias() {
    this.apiService.buscarCategorias()
      .subscribe((resposta) => this.categorias = resposta);
  }

  remover(categoriaId: number) {
    // TODO: validar se não tem cursos antes ou já deixar pro back-end (interface já mostrará).
    this.apiService.removerCategoria(categoriaId)
      .subscribe({
        next: () => {
          this.categorias = this.categorias.filter(c => c.id !== categoriaId);
        },
        error: (err: HttpErrorResponse) => {
          // TODO: feedback de erro ao remover
        }
      });
  }
}
