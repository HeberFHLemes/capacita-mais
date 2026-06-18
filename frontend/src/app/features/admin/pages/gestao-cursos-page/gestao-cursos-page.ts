import { Component, inject, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Curso } from '../../../cursos/models/curso';
import { GestaoCursoCard } from '../../components/gestao-curso-card/gestao-curso-card';
import { AdminCursosApiService } from '../../services/admin-cursos-api-service';

@Component({
  selector: 'app-gestao-cursos-page',
  imports: [RouterLink, GestaoCursoCard],
  templateUrl: './gestao-cursos-page.html',
  styleUrl: './gestao-cursos-page.css',
})
export class GestaoCursosPage implements OnInit {

  private readonly apiService: AdminCursosApiService = inject(AdminCursosApiService);

  cursos: Curso[] = [];

  ngOnInit() {
    this.carregarCursos();
  }

  carregarCursos() {
    this.apiService.buscarCursos()
      .subscribe((resposta) => this.cursos = resposta);
  }

  onRemoverCurso(cursoRemovido: Curso): void {
    this.apiService.removerCurso(cursoRemovido.id)
      .subscribe({
        next: () => {
          this.cursos = this.cursos.filter(
            curso => curso.id !== cursoRemovido.id
          );
        },
        error: err => {} // TODO: feedback de erro
      });
  }
}
