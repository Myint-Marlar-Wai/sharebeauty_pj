#!/bin/bash -eu

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)
cd "$SCRIPT_DIR"
echo "SCRIPT_DIR=$SCRIPT_DIR"

# prints colored text
print_style() {

  if [ "$2" == "info" ]; then
    COLOR="96m"
  elif [ "$2" == "success" ]; then
    COLOR="92m"
  elif [ "$2" == "warning" ]; then
    COLOR="93m"
  elif [ "$2" == "danger" ]; then
    COLOR="91m"
  else #default color
    COLOR="0m"
  fi

  STARTCOLOR="\e[$COLOR"
  ENDCOLOR="\e[0m"

  printf "$STARTCOLOR%b$ENDCOLOR" "$1"
}

display_options() {
  printf "Available options:\n"
  print_style "   list-clusters" "success"
  printf "\t クラスタ一覧.\n"
  print_style "   list-containers" "success"
  printf "\t コンテナ一覧.\n"
  print_style "   bash" "success"
  printf "\t\t\t bashで開く.\n"
  print_style "   bash-i" "success"
  printf "\t\t 対話式で対象を選択しbashで開く.\n"
}

# variables
source var.sh

echo '----------'
echo "OUTPUT=${OUTPUT:?}"
echo "AWS_PROFILE=${AWS_PROFILE:?}"
echo '----------'

if [[ $# -eq 0 ]]; then
  print_style "Missing arguments.\n" "danger"
  display_options
  exit 1
fi

exec_bash() {
  echo '----------'
  echo "CLUSTER_NAME=$CLUSTER_NAME"
  echo "SERVICE_NAME=$SERVICE_NAME"
  echo "TASK_ID=$TASK_ID"
  echo "CONTAINER_NAME=$CONTAINER_NAME"
  echo '----------'
  read -r -p "ok? (y/N): " yn
  if [[ $yn == [yY] ]]; then
    print_style "Start\n" "success"
  else
    print_style "Abort\n" "info"
    exit 0
  fi
  aws ecs execute-command \
    --cluster "$CLUSTER_NAME" \
    --task "$TASK_ID" \
    --container "$CONTAINER_NAME" \
    --interactive \
    --output "$OUTPUT" \
    --profile "$AWS_PROFILE" \
    --command "/bin/bash"
}

if [ "$1" == "list-clusters" ]; then
  print_style "クラスタ一覧.\n" "info"
  echo '----------'
  aws ecs list-clusters \
    --output "$OUTPUT" \
    --profile "$AWS_PROFILE"
  echo '----------'
elif [ "$1" == "list-containers" ]; then
  print_style "コンテナ一覧.\n" "info"
  echo '----------'
  echo "CLUSTER_NAME=$CLUSTER_NAME"
  echo "TASK_ID=$TASK_ID"
  echo '----------'
  aws ecs describe-tasks \
    --cluster "$CLUSTER_NAME" \
    --tasks "$TASK_ID" \
    --query 'tasks[*].containers[*].[name]' \
    --output text \
    --profile "$AWS_PROFILE"
  echo '----------'
elif [ "$1" == "bash" ]; then
  print_style "bashで開く.\n" "info"
  exec_bash
elif [ "$1" == "bash-i" ]; then
  print_style "対話式で対象を選択しbashで開く.\n" "info"
  print_style "List clusters.\n" "info"
  aws ecs list-clusters \
    --output text \
    --profile "$AWS_PROFILE"
  read -r -p 'Cluster name? :' CLUSTER_NAME
  echo "cluster is $CLUSTER_NAME"
  print_style "List services.\n" "info"
  aws ecs list-services \
    --cluster "$CLUSTER_NAME" \
    --output text \
    --profile "$AWS_PROFILE"
  read -r -p "Service name? :" SERVICE_NAME
  echo "service is $SERVICE_NAME"
  print_style "List tasks.\n" "info"
  aws ecs list-tasks \
    --cluster "$CLUSTER_NAME" \
    --service-name "$SERVICE_NAME" \
    --output text \
    --profile "$AWS_PROFILE"
  read -r -p "Task id? :" TASK_ID
  echo "task is $TASK_ID"
  print_style "List Containers.\n" "info"
  aws ecs describe-tasks \
    --cluster "$CLUSTER_NAME" \
    --tasks "$TASK_ID" \
    --query 'tasks[*].containers[*].[name]' \
    --output text \
    --profile "$AWS_PROFILE"
  read -r -p "Container name? :" CONTAINER_NAME
  echo "container is $CONTAINER_NAME"
  exec_bash
else
  print_style "Invalid arguments.\n" "danger"
  display_options
  exit 1
fi
