import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CarrinhoDeCompras } from './carrinho-de-compras';

describe('CarrinhoDeCompras', () => {
  let component: CarrinhoDeCompras;
  let fixture: ComponentFixture<CarrinhoDeCompras>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CarrinhoDeCompras]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CarrinhoDeCompras);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
