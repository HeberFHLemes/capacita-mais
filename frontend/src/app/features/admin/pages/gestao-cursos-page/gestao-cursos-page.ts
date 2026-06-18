import { Component, inject, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CursosApiService } from '../../../cursos/services/cursos-api-service';
import { Curso } from '../../../cursos/models/curso';
import { GestaoCursoCard } from '../../components/gestao-curso-card/gestao-curso-card';

@Component({
  selector: 'app-gestao-cursos-page',
  imports: [RouterLink, GestaoCursoCard],
  templateUrl: './gestao-cursos-page.html',
  styleUrl: './gestao-cursos-page.css',
})
export class GestaoCursosPage implements OnInit {

  private readonly cursoApiService: CursosApiService = inject(CursosApiService);

  cursos: Curso[] = [];

  ngOnInit() {
    this.carregarCursos();
  }

  carregarCursos() {
    this.cursoApiService.buscarCursos()
      .subscribe((resposta) => this.cursos = resposta);
  }

  onRemoverCurso(curso: Curso): void {
    // TODO
  }
}
