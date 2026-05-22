import { Component, EventEmitter, OnInit, Output, OnDestroy } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Subject, takeUntil } from 'rxjs';

@Component({
  selector: 'app-curso-search-bar',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './curso-search-bar.html',
  styleUrl: './curso-search-bar.css',
})
export class CursoSearchBar implements OnInit, OnDestroy {

  @Output() buscaChange = new EventEmitter<string>();

  buscaControl = new FormControl('');

  private destroy$ = new Subject<void>();

  ngOnInit(): void {
    this.buscaControl.valueChanges.pipe(
      debounceTime(300), // 300ms após o usuário terminar de digitar
      distinctUntilChanged(), // e só emite se o valor mudou
      takeUntil(this.destroy$)
    ).subscribe(valor => {
      this.buscaChange.emit(valor ?? '');
    });
  }

  ngOnDestroy(): void {
    this.destroy$.next();
    this.destroy$.complete();
  }

  limpar(): void {
    this.buscaControl.reset('');
  }
}
