# BE FR and ACL of entities

## Absence RESOURCE

* description(string)*
* absenceReason(integer)
* student(integer)*
* contactLesson(integer)*

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update   - OWN CREATED
* YES delete   - OWN CREATED

### Teacher ROLE

* YES getList
* YES get
* YES create
* YES update  - OWN CREATED ?PERIOD
* YES delete  - OWN CREATED ?PERIOD

### Student ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED
* YES create  - OWN RELATED
* YES update  - OWN CREATED ?PERIOD
* YES delete  - OWN CREATED ?PERIOD

## AbsenceReason RESOURCE

* name(string)*

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

### Teacher ROLE

* YES getList
* YES get

### Student ROLE

* YES getList
* YES get

## Administrator RESOURCE

* firstName(string)*
* lastName(string)*
* code(string)*
* lisUser(integer)

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update   - OWN CREATED
* YES delete   - OWN CREATED

### Teacher ROLE

* YES getList
* YES get

### Student ROLE

* YES getList
* YES get

## ContactLesson RESOURCE

* lessonDate(datetime)*
* description(string)*
* durationAK(integer)*
* subjectRound(integer)*
* teacher(intiger)*

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update ?PERIOD
* YES delete ?PERIOD

### Teacher ROLE

* YES getList
* YES get
* ???YES create
* ???YES update
* ???YES delete

### Student ROLE

* YES getList - OWN GROUP RELATED
* YES get     - OWN GROUP RELATED

## GradeChoice RESOURCE

* name(string)*

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

### Teacher ROLE

* YES getList
* YES get

### Student ROLE

* YES getList
* YES get

## Gradingtype RESOURCE

* gradingType(string)*

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

### Teacher ROLE

* YES getList
* YES get

### Student ROLE

* YES getList
* YES get

## IndependentWork RESOURCE

* duedate(datetime)*
* description(string)*
* durationAK(integer)*
* subjectRound(integer)*
* teacher(integer)*

### Administrator ROLE

* YES getList
* YES get

### Teacher ROLE

* YES getList
* YES get     
* YES create 
* YES update  - OWN CREATED ?PERIOD
* YES delete  - OWN CREATED ?PERIOD

### Student ROLE

* YES getList - OWN GROUP RELATED
* YES get     - OWN GROUP RELATED

## Module RESOURCE
* name
* code(integer)*
* duration(integer)*
* vocation(integer)*
* moduleType(integer)*
* gradingType

### Administrator ROLE

* YES getList
* YES get
* YES create
* YES update ?PERIOD
* YES delete ?PERIOD

### Teacher ROLE

* YES getList
* YES get

### Student ROLE

* YES getList
* YES get




