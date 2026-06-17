import { Component, Input } from '@angular/core';
import { CursoMatriculado } from '../../models/curso-matriculado';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-curso-matriculado-card',
  standalone: true,
  imports: [DatePipe],
  templateUrl: './curso-matriculado-card.html',
  styleUrl: './curso-matriculado-card.css',
})
export class CursoMatriculadoCard {

  @Input({required:true})
  curso!: CursoMatriculado;

}
