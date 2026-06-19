import { Component, EventEmitter, Input, OnChanges, Output, SimpleChanges } from '@angular/core';
import { Alerta } from "../../../../shared/components/alerta/alerta";
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from "@angular/forms";
import { RouterLink } from "@angular/router";
import { Categoria } from '../../../categorias/models/categoria';
import { CategoriaRequest } from '../../models/categoria-request';

@Component({
  selector: 'app-categoria-form',
  standalone: true,
  imports: [Alerta, FormsModule, ReactiveFormsModule, RouterLink],
  templateUrl: './categoria-form.html',
  styleUrl: './categoria-form.css',
})
export class CategoriaForm implements OnChanges {

  @Output()
  formSubmit = new EventEmitter<CategoriaRequest>();

  @Input({ required: true })
  titulo: string = 'Curso';

  @Input({required: false})
  categoria: Categoria|null = null;

  @Input()
  tipoMensagem: 'success'|'danger'|'warning'|null = null;

  @Input()
  mensagem: string|null = null;

  categoriaForm = new FormGroup({
    nome: new FormControl<string>('', {
      nonNullable: true,
      validators: [ Validators.required ]
    })
  });

  ngOnChanges(changes: SimpleChanges) {
    if (changes['categoria'] && this.categoria) {
      this.categoriaForm.patchValue({
        nome: this.categoria.nome
      });
    }
  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }

  resetar(): void {
    this.categoriaForm.reset({ nome: '' });
  }

  onSubmit(): void {
    if (this.categoriaForm.invalid) return;

    let form = this.categoriaForm.getRawValue();

    this.limparMensagem();

    let categoriaRequest: CategoriaRequest = {
      nome: form.nome
    }

    this.formSubmit.emit(categoriaRequest);
  }
}
