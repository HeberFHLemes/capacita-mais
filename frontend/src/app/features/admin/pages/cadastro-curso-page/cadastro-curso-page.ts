import { Component, inject, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { AdminCursosApiService } from '../../services/admin-cursos-api-service';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CategoriaApiService } from '../../../categorias/services/categoria-api-service';
import { Categoria } from '../../../categorias/models/categoria';
import { CursoRequest } from '../../models/curso-request';
import {Alerta} from '../../../../shared/components/alerta/alerta';
import {HttpErrorResponse} from '@angular/common/http';

@Component({
  selector: 'app-cadastro-curso-page',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule, Alerta],
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

  cadastroCursoForm = new FormGroup({
    nome: new FormControl<string>('', {
      nonNullable: true,
      validators: [ Validators.required ]
    }),
    descricao: new FormControl<string>(''),
    categoria: new FormControl<number>(0, { // id, mas começa no disabled "selecione a categoria"
      nonNullable: true,
      validators: [ Validators.required, Validators.min(1) ]
    }),
    nivel: new FormControl<'iniciante'|'intermediario'|'avancado'>('iniciante', {
      nonNullable: true,
      validators: [ Validators.required ]
    }),
    preco: new FormControl<number>(0, {
      nonNullable: true,
      validators: [ Validators.required, Validators.min(0) ]
    }),
    preco_original: new FormControl<number>(0, {
      nonNullable: true,
      validators: [ Validators.required, Validators.min(0) ]
    }),
    em_destaque: new FormControl<boolean>(false, {
      nonNullable: true,
      validators: [ Validators.required ]
    })
  });

  ngOnInit(): void {
    this.carregarCategorias();
  }

  carregarCategorias(): void {
    this.categoriasApiService.buscarCategorias()
      .subscribe((resposta) => this.categorias = resposta);
  }

  cadastrarCurso(): void {

    if (this.cadastroCursoForm.invalid) return;

    let form = this.cadastroCursoForm.getRawValue();

    if (form.preco > form.preco_original) {
      return;
    }

    let curso: CursoRequest = {
      nome: form.nome,
      descricao: form.descricao,
      categoria_id: form.categoria,
      nivel: form.nivel,
      em_destaque: form.em_destaque,
      preco: form.preco,
      preco_original: form.preco_original,
    }

    this.cursosApiService.cadastrarCurso(curso)
      .subscribe({
        next: (resposta) => {
          this.cadastroCursoForm.reset();

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
            this.mensagem = 'Curso cadastrado com sucesso!';

          }
        }
      })
  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }
}
