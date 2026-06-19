import { Component, inject, OnInit, ViewChild } from '@angular/core';
import { AdminCursosApiService } from '../../services/admin-cursos-api-service';
import { ReactiveFormsModule } from '@angular/forms';
import { CategoriaApiService } from '../../../categorias/services/categoria-api-service';
import { Categoria } from '../../../categorias/models/categoria';
import { CursoRequest } from '../../models/curso-request';
import { HttpErrorResponse } from '@angular/common/http';
import { CursoForm } from '../../components/curso-form/curso-form';

@Component({
  selector: 'app-cadastro-curso-page',
  standalone: true,
  imports: [ReactiveFormsModule, CursoForm],
  templateUrl: './cadastro-curso-page.html',
  styleUrl: './cadastro-curso-page.css',
})
export class CadastroCursoPage implements OnInit {

  private readonly cursosApiService: AdminCursosApiService = inject(AdminCursosApiService);
  private readonly categoriasApiService: CategoriaApiService = inject(CategoriaApiService);

  categorias: Categoria[] = [];

  // feedback
  mensagem: string|null = null;
  tipoMensagem: 'success'|'warning'|'danger'|null = null;

  @ViewChild(CursoForm)
  cursoForm!: CursoForm;

  ngOnInit(): void {
    this.carregarCategorias();
  }

  carregarCategorias(): void {
    this.categoriasApiService.buscarCategorias()
      .subscribe((resposta) => this.categorias = resposta);
  }

  cadastrarCurso(curso: CursoRequest): void {
    this.limparMensagem();

    this.cursosApiService.cadastrarCurso(curso)
      .subscribe({
        next: (resposta) => {
          this.cursoForm.resetar();

          this.tipoMensagem = 'success';
          this.mensagem = 'Curso cadastrado com sucesso!';
          console.log(resposta); // curso criado
        },
        error: (err: HttpErrorResponse) => {

          if (err.status === 409) {
            this.tipoMensagem = 'warning';
            this.mensagem = 'Curso já cadastrado';

          } else {
            this.tipoMensagem = 'danger';
            this.mensagem = 'Não foi possível cadastrar o curso.';

          }
        }
      })
  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }
}
