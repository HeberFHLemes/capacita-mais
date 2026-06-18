import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestaoCategoriasPage } from './gestao-categorias-page';

describe('GestaoCategoriasPage', () => {
  let component: GestaoCategoriasPage;
  let fixture: ComponentFixture<GestaoCategoriasPage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [GestaoCategoriasPage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GestaoCategoriasPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
