import { TestBed } from '@angular/core/testing';

import { PcBuilderService } from './pc-builder.service';

describe('PcBuilderService', () => {
  let service: PcBuilderService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PcBuilderService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
