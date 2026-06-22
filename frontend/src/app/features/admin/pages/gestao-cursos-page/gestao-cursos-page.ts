import { Component, inject, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Curso } from '../../../cursos/models/curso';
import { GestaoCursoCard } from '../../components/gestao-curso-card/gestao-curso-card';
import { AdminCursosApiService } from '../../services/admin-cursos-api-service';
import { Alerta } from '../../../../shared/components/alerta/alerta';

@Component({
  selector: 'app-gestao-cursos-page',
  standalone: true,
  imports: [RouterLink, GestaoCursoCard, Alerta],
  templateUrl: './gestao-cursos-page.html',
  styleUrl: './gestao-cursos-page.css',
})
export class GestaoCursosPage implements OnInit {

  private readonly apiService: AdminCursosApiService = inject(AdminCursosApiService);

  cursos: Curso[] = [];

  erro: boolean = false;
  carregando: boolean = true;

  // feedback de erro ao tentar remover um curso
  erroRemocao: string | null = null;

  ngOnInit() {
    this.carregarCursos();
  }

  carregarCursos() {
    this.carregando = true;

    this.apiService.buscarCursos()
      .subscribe({
        next: (resposta) => {
          this.cursos = resposta;
          this.carregando = false;
        },
        error: () => {
          this.erro = true;
          this.carregando = false;
        }
      });
  }

  onRemoverCurso(cursoRemovido: Curso): void {
    this.apiService.removerCurso(cursoRemovido.id)
      .subscribe({
        next: () => {
          this.cursos = this.cursos.filter(
            curso => curso.id !== cursoRemovido.id
          );
        },
        error: err => {
          this.erroRemocao = err.status === 404
            ? 'Este curso já não existe mais. Atualize a página.'
            : 'Não foi possível remover o curso. Tente novamente.';
        }
      });
  }
}
