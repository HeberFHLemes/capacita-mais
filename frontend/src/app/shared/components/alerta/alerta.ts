import { Component, Input } from '@angular/core';
import { NgClass } from '@angular/common';

@Component({
  selector: 'app-alerta',
  standalone: true,
  imports: [NgClass],
  templateUrl: './alerta.html',
  styleUrl: './alerta.css',
})
export class Alerta { // Componente para feedback ao usuário
  @Input()
  visivel = false;

  @Input()
  tipo: 'success' | 'danger' | 'warning' | 'info' | null = null;

  @Input()
  texto: string | null = null;
}
