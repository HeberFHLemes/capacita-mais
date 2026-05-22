import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CustoFilter } from './custo-filter';

describe('CustoFilter', () => {
  let component: CustoFilter;
  let fixture: ComponentFixture<CustoFilter>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CustoFilter]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CustoFilter);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
