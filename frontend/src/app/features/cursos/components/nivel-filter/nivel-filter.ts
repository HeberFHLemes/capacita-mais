import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import {NIVEIS} from '../../models/niveis';

@Component({
  selector: 'app-nivel-filter',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './nivel-filter.html',
  styleUrl: './nivel-filter.css',
})
export class NivelFilter implements OnInit {

  @Output() nivelChange = new EventEmitter<string>();

  readonly valorPadrao: string = 'todos';

  nivelControl = new FormControl(this.valorPadrao);

  protected readonly NIVEIS = NIVEIS;

  ngOnInit(): void {
    this.nivelControl.valueChanges.subscribe(valor => {
      valor = valor ?? this.valorPadrao;

      this.nivelChange.emit(valor);
    });
  }

  limpar(): void {
    this.nivelControl.setValue(this.valorPadrao);
  }
}
