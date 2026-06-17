import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CursoMatriculadoCard } from './curso-matriculado-card';

describe('CursoMatriculadoCard', () => {
  let component: CursoMatriculadoCard;
  let fixture: ComponentFixture<CursoMatriculadoCard>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CursoMatriculadoCard]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CursoMatriculadoCard);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
