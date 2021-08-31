<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-16060: Admin Unassign Custom Order Status Test")
 * @Description("Test log in to Sales and Unassign Custom Order Status Test<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminUnassignCustomOrderStatusTest.xml<br>")
 * @TestCaseId("MC-16060")
 * @group Sales
 * @group mtf_migrated
 */
class AdminUnassignCustomOrderStatusTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"UnassignCustomOrderStatus"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUnassignCustomOrderStatusTest(AcceptanceTester $I)
	{
		$I->comment("Go to new order status page");
		$I->comment("Entering Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_status"); // stepKey: goToOrderStatusPageGoToOrderStatusPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToOrderStatusPage
		$I->comment("Exiting Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->comment("Entering Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->click("#add"); // stepKey: clickCreateNewStatusClickCreateNewStatus
		$I->waitForPageLoad(30); // stepKey: clickCreateNewStatusClickCreateNewStatusWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickCreateNewStatus
		$I->comment("Exiting Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->comment("Fill the form and validate save success message");
		$I->comment("Entering Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->fillField("#edit_form [name=status]", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusCodeFillFormAndClickSave
		$I->fillField("#edit_form [name=label]", "orderLabel" . msq("defaultOrderStatus")); // stepKey: fillStatusLabelFillFormAndClickSave
		$I->click("#save"); // stepKey: clickSaveStatusFillFormAndClickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveStatusFillFormAndClickSaveWaitForPageLoad
		$I->comment("Exiting Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->comment("Entering Action Group [seeFormSaveSuccess] AssertOrderStatusFormSaveSuccess");
		$I->see("You saved the order status.", "#messages div.message-success"); // stepKey: seeSuccessSeeFormSaveSuccess
		$I->comment("Exiting Action Group [seeFormSaveSuccess] AssertOrderStatusFormSaveSuccess");
		$I->comment("Open the created order status in grid page and change the order state to Pending and verify save message");
		$I->comment("Entering Action Group [searchCreatedOrderStatus] AssertOrderStatusExistsInGrid");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersSearchCreatedOrderStatus
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchCreatedOrderStatusWaitForPageLoad
		$I->fillField("[data-role=filter-form] [name=status]", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusFilterSearchCreatedOrderStatus
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchSearchCreatedOrderStatus
		$I->see("order_status" . msq("defaultOrderStatus"), "[data-role=row] [data-column=status]"); // stepKey: seeStatusCodeInGridSearchCreatedOrderStatus
		$I->see("orderLabel" . msq("defaultOrderStatus"), "[data-role=row] [data-column=label]"); // stepKey: seeStatusLabelInGridSearchCreatedOrderStatus
		$I->comment("Exiting Action Group [searchCreatedOrderStatus] AssertOrderStatusExistsInGrid");
		$I->click("#assign"); // stepKey: clickAssignStatusToStateButton
		$I->waitForPageLoad(30); // stepKey: clickAssignStatusToStateButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAssignOrderStatusToStateLoad
		$I->selectOption("#status", "orderLabel" . msq("defaultOrderStatus")); // stepKey: selectOrderStatus
		$I->waitForPageLoad(30); // stepKey: waitForOrderStatusLoad
		$I->selectOption("#state", "Pending"); // stepKey: selectPendingInOrderState
		$I->click("#save"); // stepKey: clickSaveStatusAssignmentButton
		$I->waitForPageLoad(30); // stepKey: clickSaveStatusAssignmentButtonWaitForPageLoad
		$I->comment("Verify the order status grid page shows the updated order status");
		$I->comment("Entering Action Group [searchUpdatedOrderStatus] AssertOrderStatusExistsInGrid");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersSearchUpdatedOrderStatus
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchUpdatedOrderStatusWaitForPageLoad
		$I->fillField("[data-role=filter-form] [name=status]", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusFilterSearchUpdatedOrderStatus
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchSearchUpdatedOrderStatus
		$I->see("order_status" . msq("defaultOrderStatus"), "[data-role=row] [data-column=status]"); // stepKey: seeStatusCodeInGridSearchUpdatedOrderStatus
		$I->see("orderLabel" . msq("defaultOrderStatus"), "[data-role=row] [data-column=label]"); // stepKey: seeStatusLabelInGridSearchUpdatedOrderStatus
		$I->comment("Exiting Action Group [searchUpdatedOrderStatus] AssertOrderStatusExistsInGrid");
		$I->comment("Click unassign and verify AssertOrderStatusSuccessUnassignMessage");
		$I->click("[data-role=row] [data-column=unassign]"); // stepKey: clickUnassign
		$I->waitForPageLoad(60); // stepKey: clickUnassignWaitForPageLoad
		$I->waitForText("You have unassigned the order status.", 30, "#messages div.message-success"); // stepKey: seeAssertOrderStatusSuccessUnassignMessage
		$I->comment("Verify the order status grid page shows the updated order status and verify AssertOrderStatusInGrid");
		$I->comment("Entering Action Group [seeAssertOrderStatusInGrid] AssertOrderStatusExistsInGrid");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersSeeAssertOrderStatusInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSeeAssertOrderStatusInGridWaitForPageLoad
		$I->fillField("[data-role=filter-form] [name=status]", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusFilterSeeAssertOrderStatusInGrid
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: clickSearchSeeAssertOrderStatusInGrid
		$I->see("order_status" . msq("defaultOrderStatus"), "[data-role=row] [data-column=status]"); // stepKey: seeStatusCodeInGridSeeAssertOrderStatusInGrid
		$I->see("orderLabel" . msq("defaultOrderStatus"), "[data-role=row] [data-column=label]"); // stepKey: seeStatusLabelInGridSeeAssertOrderStatusInGrid
		$I->comment("Exiting Action Group [seeAssertOrderStatusInGrid] AssertOrderStatusExistsInGrid");
		$I->comment("Verify the order status grid page shows the updated order status and verify AssertOrderStatusNotAssigned");
		$I->dontSee("[data-role=row] [data-column=state]"); // stepKey: seeEmptyStateCodeAndTitleValue
		$I->dontSee("[data-role=row] [data-column=unassign]"); // stepKey: seeAssertOrderStatusNotAssigned
		$I->waitForPageLoad(60); // stepKey: seeAssertOrderStatusNotAssignedWaitForPageLoad
	}
}
