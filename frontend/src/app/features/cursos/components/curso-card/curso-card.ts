import { Component, Input, OnInit } from '@angular/core';
import { Curso } from '../../models/curso';
import { NIVEL_LABELS } from '../../models/nivel-labels';

@Component({
  selector: 'app-curso-card',
  standalone: true,
  templateUrl: './curso-card.html',
  styleUrl: './curso-card.css',
})
export class CursoCard implements OnInit {

  emPromocao: boolean = false;

  @Input({ required: true })
  curso!: Curso;

  ngOnInit(): void {
    this.emPromocao = this.curso.preco_original > this.curso.preco;
  }

  nivelLabel(nivelCurso: string): string{
    return NIVEL_LABELS[nivelCurso] ?? '';
  }
}
