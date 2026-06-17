import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeusCursosPage } from './meus-cursos-page';

describe('MeusCursosPage', () => {
  let component: MeusCursosPage;
  let fixture: ComponentFixture<MeusCursosPage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MeusCursosPage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MeusCursosPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
