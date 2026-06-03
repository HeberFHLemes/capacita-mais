import { Component, EventEmitter, Input, Output } from '@angular/core';
import { CategoriaFiltro } from '../../../categorias/models/categoria-filtro';

@Component({
  selector: 'app-categoria-filter',
  standalone: true,
  templateUrl: './categoria-filter.html',
  styleUrl: './categoria-filter.css',
})
export class CategoriaFilter {

  @Input({ required: true })
  categorias!: CategoriaFiltro[];

  @Output() categoriaChange = new EventEmitter<void>();

  onCheckboxChange(): void {
    this.categoriaChange.emit();
  }
}
