import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserConfigsComponent } from './userconfigs.component';

describe('UserconfigsComponent', () => {
  let component: UserConfigsComponent;
  let fixture: ComponentFixture<UserConfigsComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [UserConfigsComponent]
    });
    fixture = TestBed.createComponent(UserConfigsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
