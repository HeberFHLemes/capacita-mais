import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NivelFilter } from './nivel-filter';

describe('NivelFilter', () => {
  let component: NivelFilter;
  let fixture: ComponentFixture<NivelFilter>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NivelFilter]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NivelFilter);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
