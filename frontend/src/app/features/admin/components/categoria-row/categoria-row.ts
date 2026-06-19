import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { Categoria } from '../../../categorias/models/categoria';
import { RouterLink } from '@angular/router';
import { TooltipDirective } from '../../../../shared/directives/tooltip-directive';

@Component({
  selector: '[app-categoria-row]',
  standalone: true,
  imports: [RouterLink, TooltipDirective],
  templateUrl: './categoria-row.html',
  styleUrl: './categoria-row.css',
})
export class CategoriaRow implements OnInit {

  @Input({required: true})
  categoria!: Categoria;

  removivel: boolean = false;

  @Output()
  remover$: EventEmitter<number> = new EventEmitter();

  ngOnInit() {
    if (this.categoria.quantidade_cursos === 0) {
      this.removivel = true;
    }
  }

  remover(): void {
    if (this.removivel) {
      this.remover$.emit(this.categoria.id);
    }
  }
}
