import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CategoriaRow } from './categoria-row';

describe('CategoriaRow', () => {
  let component: CategoriaRow;
  let fixture: ComponentFixture<CategoriaRow>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CategoriaRow]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CategoriaRow);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
