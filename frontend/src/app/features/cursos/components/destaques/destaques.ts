import { Component, OnInit } from '@angular/core';
import { CursoCard } from '../curso-card/curso-card';
import { Curso } from '../../models/curso';
import { CursosApiService } from '../../services/cursos-api-service';

@Component({
  selector: 'app-destaques',
  imports: [CursoCard],
  templateUrl: './destaques.html',
  styleUrl: './destaques.css',
})
export class Destaques implements OnInit {

  cursosDestaques: Curso[] = [];

  constructor(private apiService: CursosApiService) {}

  ngOnInit(): void {
    this.buscarDestaques();
  }

  buscarDestaques() {
    this.apiService.buscarCursosEmDestaque().subscribe((cursos) => {
      this.cursosDestaques = cursos;
    });
  }
}
