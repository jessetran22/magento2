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
 * @Title("MC-5302: Create customer group already exists")
 * @Description("Create customer group already exists<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCreateCustomerGroupAlreadyExistsTest.xml<br>")
 * @TestCaseId("MC-5302")
 * @group customer
 * @group mtf_migrated
 */
class AdminCreateCustomerGroupAlreadyExistsTestCest
{
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
	 * @Features({"Customer"})
	 * @Stories({"Create customer group"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCustomerGroupAlreadyExistsTest(AcceptanceTester $I)
	{
		$I->comment("Steps: 1. Log in to backend as admin user.
                    2. Navigate to Stores > Other Settings > Customer Groups.
                    3. Start to create new Customer Group.
                    4. Fill in all data according to data set:  Group Name \"General\", Tax Class \"Retail customer\"
                    5. Click \"Save Customer Group\" button.");
		$I->comment("Assert  \"Customer Group already exists.\" error message displayed");
		$I->comment("Entering Action Group [seeErrorMessageCustomerGroupAlreadyExists] AdminAssertErrorMessageCustomerGroupAlreadyExists");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/new/"); // stepKey: goToNewCustomerGroupPageSeeErrorMessageCustomerGroupAlreadyExists
		$I->waitForPageLoad(30); // stepKey: waitForNewCustomerGroupPageLoadSeeErrorMessageCustomerGroupAlreadyExists
		$I->comment("Set tax class for customer group");
		$I->fillField("#customer_group_code", "General"); // stepKey: fillGroupNameSeeErrorMessageCustomerGroupAlreadyExists
		$I->selectOption("#tax_class_id", "Retail Customer"); // stepKey: selectTaxClassOptionSeeErrorMessageCustomerGroupAlreadyExists
		$I->click("#save"); // stepKey: clickToSaveCustomerGroupSeeErrorMessageCustomerGroupAlreadyExists
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSavedSeeErrorMessageCustomerGroupAlreadyExists
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForElementVisibleSeeErrorMessageCustomerGroupAlreadyExists
		$I->see("Customer Group already exists.", "#messages div.message-error"); // stepKey: seeErrorMessageSeeErrorMessageCustomerGroupAlreadyExists
		$I->comment("Exiting Action Group [seeErrorMessageCustomerGroupAlreadyExists] AdminAssertErrorMessageCustomerGroupAlreadyExists");
	}
}
