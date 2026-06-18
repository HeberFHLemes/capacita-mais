import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Curso } from '../../../cursos/models/curso';
import { NIVEL_LABELS } from '../../../cursos/models/nivel-labels';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-gestao-curso-card',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './gestao-curso-card.html',
  styleUrl: './gestao-curso-card.css',
})
export class GestaoCursoCard implements OnInit {

  @Input({required: true})
  curso!: Curso;

  emPromocao: boolean = false;
  nivelCurso: string = '';

  ngOnInit() {
    this.emPromocao = this.curso.preco < this.curso.preco_original;
    this.nivelCurso = NIVEL_LABELS[this.curso.nivel];
  }

  @Output()
  remover$: EventEmitter<Curso> = new EventEmitter();

  remover(): void {
    this.remover$.emit(this.curso);
  }
}
