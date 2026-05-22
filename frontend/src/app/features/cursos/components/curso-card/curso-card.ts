import { Component, Input } from '@angular/core';
import { Curso } from '../../models/curso';

@Component({
  selector: 'app-curso-card',
  standalone: true,
  templateUrl: './curso-card.html',
  styleUrl: './curso-card.css',
})
export class CursoCard {

  @Input({ required: true })
  curso!: Curso;

}
