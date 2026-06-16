import { inject, Injectable } from '@angular/core';
import { Carrinho } from '../models/carrinho';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ItemCarrinho } from '../models/item-carrinho';

@Injectable({
  providedIn: 'root',
})
export class CarrinhoApiService {

  private readonly apiBaseUrl = '/api/carrinho';

  private readonly httpClient: HttpClient = inject(HttpClient);

  buscarCarrinho(): Observable<Carrinho> {
    return this.httpClient.get<Carrinho>(this.apiBaseUrl);
  }

  inserirItemNoCarrinho(itemId: number): Observable<ItemCarrinho> {
    return this.httpClient.post<ItemCarrinho>(
      `${this.apiBaseUrl}/itens`, { curso_id: itemId }
    );
  }

  removerItemDoCarrinho(itemId: number): Observable<void> {
    return this.httpClient.delete<void>(
      `${this.apiBaseUrl}/itens/${itemId}`
    )
  }

  // TODO: enviar pedido de compra ao back-end
  confirmarCompra(carrinho: Carrinho): Observable<void> {
    return this.httpClient.post<void>(`/api/compras`, carrinho);
  }
}
