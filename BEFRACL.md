# BE FR and ACL of entities


## Administrator RESOURCE

* firstName(string)*
* lastName(string)*
* code(string)*
* lisUser(integer)

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update   - OWN CREATED
* YES delete   - OWN CREATED

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## ContactLesson RESOURCE

* lessonDate(datetime)*
* description(string)*
* durationAK(integer)*
* subjectRound(integer)*
* teacher(intiger)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update ?PERIOD
* YES delete ?PERIOD

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## GradeChoice RESOURCE

* name(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## Gradingtype RESOURCE

* gradingType(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## IndependentWork RESOURCE

* duedate(datetime)*
* description(string)*
* durationAK(integer)*
* subjectRound(integer)*
* teacher(integer)*

####  Administrator ROLE

* YES getList
* YES get

####  Teacher ROLE

* YES getList
* YES get     
* YES create 
* YES update  - OWN CREATED ?PERIOD
* YES delete  - OWN CREATED ?PERIOD

####  Student ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED

## Module RESOURCE

* name(string)*
* code(string)*
* duration(integer)*
* vocation(integer)*
* moduleType(integer)*
* gradingType(integer)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## ModuleType RESOURCE

* name(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update ?PERIOD
* YES delete ?PERIOD

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## Room RESOURCE

* name(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## Student RESOURCE

* firstName(string)*
* lastName(string)*
* code(string)*
* email(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED

## StudentGrade RESOURCE

* notes(string)
* student(integer)*
* gradeChoice(integer)*
* teacher(intiger)*
* independentWork(integer)
* module(integer)
* subjectRound(integer)
* contactLesson(integer)

####  Administrator ROLE

* YES getList
* YES get

####  Teacher ROLE

* YES getList
* YES get
* YES create
* YES update OWN CREATED
* YES delete OWN CREATED

####  Student ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED

## StudentGroup RESOURCE

* name(string)*
* vocation(integer)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## StudentInGroups RESOURCE

* student(integer)*
* studentGroup(integer)*
* status(integer)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList SELF RELATED
* YES get SELF RELATED

## Subject RESOURCE

* code(integer)*
* name(string)*
* durationAllAK(integer)*
* durationContactAK(integer)*
* durationIndependentAK(integer)*
* module(integer)*
* gradingType(array of integers)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get

## SubjectRound RESOURCE

* subject(integer)*
* studentGroup(integer)*
* teacher(array) [ { id(integer) } ] ]*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED

####  Student ROLE

* YES getList
* YES get

## Teacher RESOURCE

* firstName(string)*
* lastName(string)*
* code(string)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList - OWN RELATED
* YES get     - OWN RELATED

####  Student ROLE

* YES getList
* YES get

## Vocation RESOURCE

* name(string)*
* code(string)*
* durationEKAP(integer)*

####  Administrator ROLE

* YES getList
* YES get
* YES create
* YES update
* YES delete

####  Teacher ROLE

* YES getList
* YES get

####  Student ROLE

* YES getList
* YES get








