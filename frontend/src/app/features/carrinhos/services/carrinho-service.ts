import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CarrinhoService {

  // Para gerenciar o abrir/fechar do offcanvas (carrinho de compras)
  private abertoSubject = new BehaviorSubject(false);
  readonly aberto$ = this.abertoSubject.asObservable();

  abrir(): void {
    this.abertoSubject.next(true);
  }

  fechar(): void {
    this.abertoSubject.next(false);
  }

  abrirOuFechar(): void {
    this.abertoSubject.next(!this.abertoSubject.value);
  }
}
