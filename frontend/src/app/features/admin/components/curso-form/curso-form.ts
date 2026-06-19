import {Component, EventEmitter, Input, OnChanges, Output, SimpleChanges} from '@angular/core';
import { Curso } from '../../../cursos/models/curso';
import { Alerta } from '../../../../shared/components/alerta/alerta';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { CursoRequest } from '../../models/curso-request';
import { Categoria } from '../../../categorias/models/categoria';

@Component({
  selector: 'app-curso-form',
  standalone: true,
  imports: [Alerta, ReactiveFormsModule, RouterLink],
  templateUrl: './curso-form.html',
  styleUrl: './curso-form.css',
})
export class CursoForm implements OnChanges {
  // reutilizado tanto para cadastro quanto para edição
  // mas para edição já recebe o curso e popula os campos.

  @Output()
  formSubmit = new EventEmitter<CursoRequest>();

  @Input({ required: false })
  curso?: Curso;

  @Input({ required: true })
  titulo: string = 'Curso';

  @Input({ required: true })
  categorias: Categoria[] = [];

  @Input()
  mensagem: string|null = null;

  @Input()
  tipoMensagem: 'success'|'warning'|'danger'|null = null;

  cursoForm = new FormGroup({
    nome: new FormControl<string>('', {
      nonNullable: true,
      validators: [ Validators.required ]
    }),
    descricao: new FormControl<string>(''),
    categoria: new FormControl<number>(0, { // id, mas começa no disabled "selecione a categoria"
      nonNullable: true,
      validators: [ Validators.required, Validators.min(1) ]
    }),
    nivel: new FormControl<'iniciante'|'intermediario'|'avancado'>('iniciante', {
      nonNullable: true,
      validators: [ Validators.required ]
    }),
    preco: new FormControl<number>(0, {
      nonNullable: true,
      validators: [ Validators.required, Validators.min(0) ]
    }),
    preco_original: new FormControl<number>(0, {
      nonNullable: true,
      validators: [ Validators.required, Validators.min(0) ]
    }),
    em_destaque: new FormControl<boolean>(false, {
      nonNullable: true,
      validators: [ Validators.required ]
    })
  });

  ngOnChanges(changes: SimpleChanges) {
    if (changes['curso'] && this.curso) {
      this.cursoForm.patchValue({
        nome: this.curso.nome,
        descricao: this.curso.descricao,
        categoria: this.curso.categoria.id,
        nivel: this.curso.nivel as ('iniciante'|'intermediario'|'avancado'),
        preco: this.curso.preco,
        preco_original: this.curso.preco_original,
        em_destaque: this.curso.em_destaque
      });
    }
  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }

  resetar(): void {
    this.cursoForm.reset({
      nome: '',
      descricao: '',
      categoria: 0,
      nivel: 'iniciante',
      preco: 0,
      preco_original: 0,
      em_destaque: false
    });
  }

  onSubmit(): void {
    if (this.cursoForm.invalid) return;

    let form = this.cursoForm.getRawValue();

    if (form.preco > form.preco_original) {
      this.tipoMensagem = 'danger';
      this.mensagem = 'Preço deve ser menor ou igual que o preço original';
      return;
    }

    this.limparMensagem();

    let cursoRequest: CursoRequest = {
      nome: form.nome,
      descricao: form.descricao,
      categoria_id: form.categoria,
      nivel: form.nivel,
      em_destaque: form.em_destaque,
      preco: form.preco,
      preco_original: form.preco_original,
    }

    this.formSubmit.emit(cursoRequest);
  }
}
