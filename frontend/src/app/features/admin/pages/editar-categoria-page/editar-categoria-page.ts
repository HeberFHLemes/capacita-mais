import { Component, inject, OnInit, ViewChild } from '@angular/core';
import { CategoriaForm } from '../../components/categoria-form/categoria-form';
import { ActivatedRoute } from '@angular/router';
import { Categoria } from '../../../categorias/models/categoria';
import { CategoriaRequest } from '../../models/categoria-request';
import { HttpErrorResponse } from '@angular/common/http';
import { AdminCategoriasApiService } from '../../services/admin-categorias-api-service';

@Component({
  selector: 'app-editar-categoria-page',
  standalone: true,
  imports: [CategoriaForm],
  templateUrl: './editar-categoria-page.html',
  styleUrl: './editar-categoria-page.css',
})
export class EditarCategoriaPage implements OnInit {

  private readonly categoriasApiService: AdminCategoriasApiService = inject(AdminCategoriasApiService);
  private readonly route: ActivatedRoute = inject(ActivatedRoute);

  categoria?: Categoria;
  categoriaId?: number;

  @ViewChild(CategoriaForm)
  categoriaForm!: CategoriaForm;

  mensagem: string|null = null;
  tipoMensagem: 'danger'|'success'|'warning'|null = null;

  ngOnInit() {
    this.carregarDadosDaCategoria();
  }

  carregarDadosDaCategoria() {
    // lê o id da categoria na URL
    this.route.paramMap
      .subscribe(params => {
        const categoriaId = Number(params.get('id'));

        this.categoriaId = categoriaId;

        this.categoriasApiService.buscarCategoriaPorId(categoriaId)
          .subscribe(resposta => {
            this.categoria = resposta;
          })
      });
  }

  editarCategoria(categoria: CategoriaRequest): void {
    this.tipoMensagem = null;
    this.mensagem = null;

    if (!this.categoriaId) {
      return;
    }

    this.categoriasApiService.editarCategoria(categoria, this.categoriaId)
      .subscribe({
        next: (resposta) => {

          if (resposta) {
            this.categoria = resposta;
          }

          this.tipoMensagem = 'success';
          this.mensagem = 'Categoria editada com sucesso!';
          console.log(resposta);
        },
        error: (err: HttpErrorResponse) => {
          if (err.status === 409) {
            this.tipoMensagem = 'warning';
            this.mensagem = 'Categoria já existente';

          } else {
            this.tipoMensagem = 'danger';
            this.mensagem = 'Não foi possível editar a categoria.';

          }
        }
      });
  }
}
