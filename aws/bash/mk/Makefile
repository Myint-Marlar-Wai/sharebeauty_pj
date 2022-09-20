
include var.mk

#-----------------------------------------------------
# variables
#-----------------------------------------------------

#-----------------------------------------------------
# util
#-----------------------------------------------------
all:
	@echo "ecs utils"

list-clusters:
	aws ecs list-clusters \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)

list-svs:
	aws ecs list-services \
	--cluster $(CLUSTER_NAME) \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)

list-tasks:
	aws ecs list-tasks \
	--cluster $(CLUSTER_NAME) \
	--service-name $(SERVICE_NAME) \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)


list-ctr-instances:
	aws ecs list-container-instances \
	--cluster $(CLUSTER_NAME) \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)

describe-svc:
	aws ecs describe-services \
	--cluster $(CLUSTER_NAME) \
	--service $(SERVICE_NAME) \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)

describe-task:
	aws ecs describe-tasks \
	--cluster $(CLUSTER_NAME) \
	--tasks $(TASK) \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)

get-ctr-name:
	aws ecs describe-tasks \
	--cluster $(CLUSTER_NAME) \
	--tasks $(TASK) \
	--query 'tasks[*].containers[*].name' \
	--output text \
	--profile $(AWS_PROFILE)

bash:
	aws ecs execute-command \
	--cluster $(CLUSTER_NAME) \
	--task $(TASK) \
	--container $(CONTAINER_NAME) \
	--interactive \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE) \
	--command "/bin/bash"

enable-execute-command:
	aws ecs update-service \
	--cluster $(CLUSTER_NAME) \
	--service $(SERVICE_NAME) \
	--enable-execute-command \
	--output $(OUTPUT) \
	--profile $(AWS_PROFILE)
