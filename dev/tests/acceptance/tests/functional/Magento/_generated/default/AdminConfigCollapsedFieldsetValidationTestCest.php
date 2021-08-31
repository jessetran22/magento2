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
 * @Title("MC-35785: Verify that form validation triggered on element inside hidden fieldset opens the fieldset in case of error")
 * @Description("Verify that form validation triggered on element inside hidden fieldset opens the fieldset in case of error<h3>Test files</h3>app/code/Magento/Config/Test/Mftf/Test/AdminConfigCollapsedFieldsetValidationTest.xml<br>")
 * @TestCaseId("MC-35785")
 * @group configuration
 */
class AdminConfigCollapsedFieldsetValidationTestCest
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
	 * @Features({"Config"})
	 * @Stories({"Configuration Form Validation"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigCollapsedFieldsetValidationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToConfigurationPage] AdminOpenStoreConfigCatalogPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: openAdminStoreConfigPageNavigateToConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToConfigurationPage
		$I->comment("Exiting Action Group [navigateToConfigurationPage] AdminOpenStoreConfigCatalogPageActionGroup");
		$I->comment("Entering Action Group [expandStorefrontTab] AdminConfigExpandStorefrontTabActionGroup");
		$I->conditionalClick("#catalog_frontend-head", "#catalog_frontend-head:not(.open)", true); // stepKey: expandStorefrontTabExpandStorefrontTab
		$I->comment("Exiting Action Group [expandStorefrontTab] AdminConfigExpandStorefrontTabActionGroup");
		$I->comment("Entering Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->uncheckOption("#row_catalog_frontend_grid_per_page_values > .use-default > input"); // stepKey: uncheckUseSystemValueUncheckUseSystemValue
		$I->uncheckOption("#row_catalog_frontend_grid_per_page_values > .use-default > input"); // stepKey: uncheckCheckboxUncheckUseSystemValue
		$I->comment("Exiting Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->comment("Entering Action Group [fillInputField] AdminConfigFillInputFilterFieldActionGroup");
		$I->fillField("//input[@id='catalog_frontend_grid_per_page_values']", ""); // stepKey: fillInputFieldFillInputField
		$I->comment("Exiting Action Group [fillInputField] AdminConfigFillInputFilterFieldActionGroup");
		$I->comment("Entering Action Group [collapseStorefrontTab] AdminConfigCollapseStorefrontTabActionGroup");
		$I->conditionalClick("#catalog_frontend-head", "#catalog_frontend-head.open", true); // stepKey: collapseStorefrontTabCollapseStorefrontTab
		$I->comment("Exiting Action Group [collapseStorefrontTab] AdminConfigCollapseStorefrontTabActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtn
		$I->comment("Entering Action Group [assertValidationError] AssertAdminValidationErrorActionGroup");
		$I->see("This is a required field.", "#catalog_frontend_grid_per_page_values-error"); // stepKey: seeElementValidationErrorAssertValidationError
		$I->comment("Exiting Action Group [assertValidationError] AssertAdminValidationErrorActionGroup");
	}
}
