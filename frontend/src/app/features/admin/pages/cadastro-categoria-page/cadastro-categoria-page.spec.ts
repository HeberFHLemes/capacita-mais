import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastroCategoriaPage } from './cadastro-categoria-page';

describe('CadastroCategoriaPage', () => {
  let component: CadastroCategoriaPage;
  let fixture: ComponentFixture<CadastroCategoriaPage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CadastroCategoriaPage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CadastroCategoriaPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
