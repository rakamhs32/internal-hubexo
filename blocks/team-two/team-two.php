<?php

$title       = get_field( 'title' );
$teamMembers = get_field( 'team_members' );
$ManagementOne = get_field('management_one');
$ManagementTwo = get_field('management_two');

$selectCountry = get_field( 'select_country' ); // Get the selected countries as an array
if ( $selectCountry && is_array( $selectCountry ) ) {
    $countries = implode( ',', $selectCountry );
} else {
    $countries = '';
}

$BlockId  = get_field( 'block_id' );
$BlockCss = get_field( 'block_css' );
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the filter buttons
        const groupManagementBtn = document.getElementById('groupManagement');
        const managementBtn = document.getElementById('Management');

        // Get all team items
        const teamItems = document.querySelectorAll('.team-item');

        // Set Group Management as active by default when page loads
        groupManagementBtn.classList.add('active');

        // Hide Management items by default
        teamItems.forEach(function(item) {
            if (item.getAttribute('data-management') === 'Management') {
                item.classList.add('hide');
            }
        });

        // Add click event listener to Group Management button
        groupManagementBtn.addEventListener('click', function() {
            // First, remove active class if we want to style the active button
            managementBtn.classList.remove('active');
            groupManagementBtn.classList.add('active');

            // Loop through all team items
            teamItems.forEach(function(item) {
                // If item has Management data attribute, hide it
                if (item.getAttribute('data-management') === 'Management') {
                    item.classList.add('hide');
                }
                // If item has groupManagement data attribute, show it
                else if (item.getAttribute('data-management') === 'groupManagement') {
                    item.classList.remove('hide');
                }
                // Items without data-management attribute remain visible by default
            });
        });

        // Add click event listener to Management button
        managementBtn.addEventListener('click', function() {
            // Update active class
            groupManagementBtn.classList.remove('active');
            managementBtn.classList.add('active');

            // Loop through all team items
            teamItems.forEach(function(item) {
                // If item has groupManagement data attribute, hide it
                if (item.getAttribute('data-management') === 'groupManagement') {
                    item.classList.add('hide');
                }
                // If item has Management data attribute, show it
                else if (item.getAttribute('data-management') === 'Management') {
                    item.classList.remove('hide');
                }
                // Items without data-management attribute remain visible by default
            });
        });

        // Create a container for the expanded detail content
        const detailContainer = document.createElement('div');
        detailContainer.className = 'expanded-detail-container';
        document.querySelector('.block-teams').appendChild(detailContainer);

        // Track the currently active team item
        let activeTeamItem = null;

        // Add click event listeners to all View Profile buttons
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                // Prevent default link behavior
                event.preventDefault();

                // Find the parent team-item
                const teamItem = this.closest('.team-item');

                // Find the detail-content within this team-item
                const detailContent = teamItem.querySelector('.detail-content');

                // Check if clicking the same item or a new one
                const isCurrentlyActive = teamItem === activeTeamItem;

                // Reset previously active team item
                if (activeTeamItem && activeTeamItem !== teamItem) {
                    // No need to remove active class as we're not adding it anymore
                }

                // Toggle visibility of expanded container
                if (isCurrentlyActive) {
                    // If clicking the active item, hide the expanded content
                    detailContainer.style.display = 'none';
                    activeTeamItem = null;
                } else {
                    // Set this as the active team item
                    activeTeamItem = teamItem;

                    // Get the position of the team item for positioning the expanded content
                    const teamItemRect = teamItem.getBoundingClientRect();
                    const containerRect = document.querySelector('.block-teams').getBoundingClientRect();

                    // Clone the detail content for display in the expanded container
                    const detailClone = detailContent.cloneNode(true);
                    detailClone.classList.add('expanded');

                    // Clear previous expanded content
                    detailContainer.innerHTML = '';
                    detailContainer.appendChild(detailClone);

                    // Position the expanded container
                    detailContainer.style.display = 'block';
                    detailContainer.style.top = (teamItemRect.bottom - containerRect.top) + 'px';

                    // Add close button to the expanded detail
                    const closeButton = document.createElement('button');
                    closeButton.className = 'close-detail-btn';
                    closeButton.innerHTML = '&times;';
                    closeButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        detailContainer.style.display = 'none';
                        activeTeamItem = null;
                    });
                    detailClone.appendChild(closeButton);
                }

                // Stop event propagation to prevent immediate closing
                event.stopPropagation();
            });
        });

        // Add hover and click event listeners to all img-content elements
        const imgContents = document.querySelectorAll('.img-content');
        imgContents.forEach(function(imgContent) {
            // Find the front-content within the same team-item
            const frontContent = imgContent.closest('.team-item').querySelector('.front-content');

            // Add mouseenter event (hover in)
            imgContent.addEventListener('mouseenter', function() {
                if (!frontContent.classList.contains('clicked')) {
                    frontContent.classList.add('active');
                }
            });

            // Add mouseleave event (hover out)
            imgContent.addEventListener('mouseleave', function() {
                // Only remove active if it wasn't activated by click
                if (!frontContent.classList.contains('clicked')) {
                    frontContent.classList.remove('active');
                }
            });

            // Add click event for toggle functionality - FIXED VERSION
            imgContent.addEventListener('click', function() {
                // If already clicked, remove both classes
                if (frontContent.classList.contains('clicked')) {
                    frontContent.classList.remove('clicked');
                    frontContent.classList.remove('active');
                } else {
                    // Otherwise, add both classes
                    frontContent.classList.add('active');
                    frontContent.classList.add('clicked');
                }
            });
        });

        // Close expanded detail when clicking outside
        document.addEventListener('click', function(event) {
            // Check if the click is outside both the team items and the expanded container
            const isOutsideTeamItems = !event.target.closest('.team-item');
            const isOutsideExpandedDetail = !event.target.closest('.expanded-detail-container');

            if (isOutsideTeamItems && isOutsideExpandedDetail) {
                // Hide the expanded container
                detailContainer.style.display = 'none';
                activeTeamItem = null;
            }
        });

        // Optional: Add CSS for the necessary styles
        if (!document.querySelector('style#team-filter-styles')) {
            const style = document.createElement('style');
            style.id = 'team-filter-styles';
            style.textContent = `
            .hide {
                display: none !important;
            }

            /* Optional: Style for active buttons */
            .position-teams p.active {
                font-weight: bold;
                text-decoration: none;
            }

            /* Default state for original detail content - keep completely hidden */
            .detail-content {
                display: none;
            }

            /* Container for the expanded detail */
            .expanded-detail-container {
                display: none;
                position: absolute;
                left: 0;
                width: 100%;
                z-index: 100;
                background: var(--earth);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                padding: 20px;
                box-sizing: border-box;
                top: 0px !important;
                z-index: 10000;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                right: 0;
                height: 100%;
                overflow: scroll;
            }

            /* Expanded detail inside the container */
            .detail-content.expanded {
                display: block;
                position: relative;
                max-width: 1200px;
                margin: 0 auto;
            }

            /* Close button for the expanded detail */
            .close-detail-btn {
                position: absolute;
                top: -4px;
                right: 10px;
                background: transparent;
                border: none;
                font-size: 24px;
                cursor: pointer;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #333;
            }

            .close-detail-btn:hover {
                color: #000;
            }
        `;
            document.head.appendChild(style);
        }
    });
</script>

<div class="content-panel team aluminium-bg <?= $BlockCss; ?>" data-country="<?= esc_attr($countries) ?>">
    <div class="container fade-in">
        <div class="teams-section">
            <h2 class="h5 snug"><?= $title ?></h2>
            <div class="block-teams">
                <div class="position-teams">
                    <p class="" id="groupManagement">Group Management</p>
                    <p class="" id="Management">Management</p>
                </div>
                <div class="list-teams">
                    <?php foreach ( $teamMembers as $teamMember ):
                        $name = $teamMember['name'];
                        $jobTitle = $teamMember['job_title'];
                        $Management = $teamMember['management'];
                        $image = $teamMember['image'];
                        $bio = $teamMember['bio'];
                        $email_text_button = $teamMember['email_text_button'];
                        $link_email = $teamMember['link_email'];
                        $email = $teamMember['email'] ?? false;

                        ?>

                    <div class="team-item" data-management="<?= $Management; ?>">
                        <div class="img-content">
                            <?php if ( $image ): ?>
                                <img src="<?= $image['sizes']['thumbnail']; ?>" alt="<?= $image['alt']; ?>" class="image-teams">
                            <?php endif; ?>
                            <div class="front-content">
                                <p class="name-team"><?= $name; ?></p>
                                <p class="title-team"><?= $jobTitle; ?></p>
                                <?php if (!empty($bio)) : ?>
                                <a href="" class="view-btn">
                                    <p>View Profile</p>
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="detail-content">
                                <div class="head-detail-content">
                                    <p class="name-team"><?= $name; ?></p>
                                    <p class="title-team"><?= $jobTitle; ?></p>
                                    <?php if (!empty($link_email)) : ?>
                                        <a href="mailto:<?= $link_email ?>" class="view-btn">
                                            <p><?= $email_text_button ?></p>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?= $bio; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>