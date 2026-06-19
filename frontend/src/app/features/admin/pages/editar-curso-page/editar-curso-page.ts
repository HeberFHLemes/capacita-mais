import { Component, inject, OnInit, ViewChild } from '@angular/core';
import { AdminCursosApiService } from '../../services/admin-cursos-api-service';
import { Curso } from '../../../cursos/models/curso';
import { Categoria } from '../../../categorias/models/categoria';
import { ActivatedRoute } from '@angular/router';
import { CategoriaApiService } from '../../../categorias/services/categoria-api-service';
import { CursoRequest } from '../../models/curso-request';
import { CursoForm } from '../../components/curso-form/curso-form';
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-editar-curso-page',
  standalone: true,
  imports: [CursoForm],
  templateUrl: './editar-curso-page.html',
  styleUrl: './editar-curso-page.css',
})
export class EditarCursoPage implements OnInit {

  private readonly cursosApiService: AdminCursosApiService = inject(AdminCursosApiService);
  private readonly categoriasApiService: CategoriaApiService = inject(CategoriaApiService);
  private readonly route: ActivatedRoute = inject(ActivatedRoute);

  curso?: Curso
  cursoId?: number;
  categorias: Categoria[] = [];

  @ViewChild(CursoForm)
  cursoForm!: CursoForm;

  mensagem: string|null = null;
  tipoMensagem: 'danger'|'success'|'warning'|null = null;

  ngOnInit() {
    this.carregarDadosDoCurso();
    this.carregarCategorias();
  }

  carregarDadosDoCurso() {
    // lê o id do curso na URL
    this.route.paramMap
      .subscribe(params => {
        const cursoId = Number(params.get('id'));

        this.cursoId = cursoId;

        this.cursosApiService.buscarCursoPorId(cursoId)
          .subscribe(curso => {
            this.curso = curso;
          })
      });
  }

  carregarCategorias() {
    this.categoriasApiService.buscarCategorias()
      .subscribe(categorias => {
        this.categorias = categorias;
      })
  }

  editarCurso(curso: CursoRequest): void {
    this.tipoMensagem = null;
    this.mensagem = null;

    if (!this.cursoId) {
      return;
    }

    this.cursosApiService.editarCurso(curso, this.cursoId)
      .subscribe({
        next: (resposta) => {
          if (!resposta.editado) {
            this.tipoMensagem = 'warning';
            this.mensagem = 'Curso sem alterações';
            return;
          }

          if (resposta.curso) {
            this.curso = resposta.curso;
          }

          this.tipoMensagem = 'success';
          this.mensagem = 'Curso editado com sucesso!';
          console.log(resposta);
        },
        error: (err: HttpErrorResponse) => {
          if (err.status === 409) {
            this.tipoMensagem = 'warning';
            this.mensagem = 'Curso já existente';

          } else {
            this.tipoMensagem = 'danger';
            this.mensagem = 'Não foi possível editar o curso.';

          }
        }
      });
  }
}
