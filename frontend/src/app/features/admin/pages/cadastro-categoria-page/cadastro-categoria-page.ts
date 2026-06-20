import { Component, inject, ViewChild } from '@angular/core';
import { CategoriaForm } from '../../components/categoria-form/categoria-form';
import { CategoriaRequest } from '../../models/categoria-request';
import { HttpErrorResponse } from '@angular/common/http';
import { AdminCategoriasApiService } from '../../services/admin-categorias-api-service';

@Component({
  selector: 'app-cadastro-categoria-page',
  standalone: true,
  imports: [CategoriaForm],
  templateUrl: './cadastro-categoria-page.html',
  styleUrl: './cadastro-categoria-page.css',
})
export class CadastroCategoriaPage {

  private readonly categoriasApiService: AdminCategoriasApiService = inject(AdminCategoriasApiService);

  // feedback
  mensagem: string|null = null;
  tipoMensagem: 'success'|'warning'|'danger'|null = null;

  @ViewChild(CategoriaForm)
  categoriaForm!: CategoriaForm;

  cadastrarCategoria(categoria: CategoriaRequest): void {
    this.limparMensagem();

    this.categoriasApiService.cadastrarCategoria(categoria)
      .subscribe({
        next: (resposta) => {
          this.categoriaForm.resetar();

          this.tipoMensagem = 'success';
          this.mensagem = 'Categoria cadastrada com sucesso!';
          console.log(resposta); // categoria criada
        },
        error: (err: HttpErrorResponse) => {

          if (err.status === 409) {
            this.tipoMensagem = 'warning';
            this.mensagem = 'Categoria já cadastrada';

          } else {
            this.tipoMensagem = 'danger';
            this.mensagem = 'Não foi possível cadastrar a categoria.';

          }
        }
      });
  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }
}
