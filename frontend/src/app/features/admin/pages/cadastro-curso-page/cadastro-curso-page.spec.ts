import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastroCursoPage } from './cadastro-curso-page';

describe('CadastroCursoPage', () => {
  let component: CadastroCursoPage;
  let fixture: ComponentFixture<CadastroCursoPage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CadastroCursoPage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CadastroCursoPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
