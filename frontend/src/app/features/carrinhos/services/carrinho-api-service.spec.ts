import { TestBed } from '@angular/core/testing';

import { CarrinhoApiService } from './carrinho-api-service';

describe('CarrinhoApiService', () => {
  let service: CarrinhoApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CarrinhoApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
