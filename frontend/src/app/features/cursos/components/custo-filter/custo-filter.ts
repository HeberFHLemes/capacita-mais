import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-custo-filter',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './custo-filter.html',
  styleUrl: './custo-filter.css',
})
export class CustoFilter implements OnInit {

  @Output() custoChange = new EventEmitter<string>();

  custoControl = new FormControl('todos');

  ngOnInit(): void {
    this.custoControl.valueChanges.subscribe(valor => {
      this.custoChange.emit(valor ?? 'todos');
    });
  }

  limpar(): void {
    this.custoControl.setValue('todos');
  }
}
