######################
# Default parameters #
######################
IMAGE_NAME := kuickphp/event

.PHONY test:
	# generate CI_TAG to avoid concurrent run collisions
	$(eval CI_TAG := $(IMAGE_NAME):$(shell date +%s%N))
	docker build --target=test-runner --tag $(CI_TAG) .
	docker run --rm -v ./:/var/www/html $(CI_TAG) sh -c "composer up && composer fix:phpcbf && composer test:phpunit"
	docker image rm $(CI_TAG)
