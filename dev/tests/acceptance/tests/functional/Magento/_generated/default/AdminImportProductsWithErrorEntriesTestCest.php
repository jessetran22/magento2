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
 * @Title("MC-6358: Import products with error entries")
 * @Description("Verify import status during import products with error entries<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminImportProductsWithErrorEntriesTest.xml<br>")
 * @TestCaseId("MC-6358")
 * @group importExport
 */
class AdminImportProductsWithErrorEntriesTestCest
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
		$I->comment("Login to Admin Page");
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
		$I->comment("Clear products grid filters");
		$I->comment("Entering Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearProductsGridFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] AdminClearFiltersActionGroup");
		$I->comment("Delete all imported products");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteAllProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logoutFromAdminPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPage
		$I->comment("Exiting Action Group [logoutFromAdminPage] AdminLogoutActionGroup");
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
	 * @Features({"ImportExport"})
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportProductsWithErrorEntriesTest(AcceptanceTester $I)
	{
		$I->comment("Import products with \"Skip error entries\"");
		$I->comment("Entering Action Group [importProductsWithSkipErrorEntries] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProductsWithSkipErrorEntries
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProductsWithSkipErrorEntries
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProductsWithSkipErrorEntries
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProductsWithSkipErrorEntries
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProductsWithSkipErrorEntries
		$I->selectOption("#basic_behaviorvalidation_strategy", "Skip error entries"); // stepKey: selectValidationStrategyOptionImportProductsWithSkipErrorEntries
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportProductsWithSkipErrorEntries
		$I->attachFile("#import_file", "catalog_product_err_img.csv"); // stepKey: attachFileForImportImportProductsWithSkipErrorEntries
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProductsWithSkipErrorEntries
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductsWithSkipErrorEntriesWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForValidationNoticeMessageImportProductsWithSkipErrorEntries
		$I->see("Checked rows: 10, checked entities: 10, invalid rows: 0, total errors: 0", "#import_validation_messages .message-notice"); // stepKey: seeValidationNoticeMessageImportProductsWithSkipErrorEntries
		$I->see("File is valid! To start import process press \"Import\" button", "#import_validation_messages .message-success"); // stepKey: seeValidationMessageImportProductsWithSkipErrorEntries
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProductsWithSkipErrorEntries
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductsWithSkipErrorEntriesWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProductsWithSkipErrorEntries
		$I->see("Created: 10, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProductsWithSkipErrorEntries
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportProductsWithSkipErrorEntries
		$I->comment("Exiting Action Group [importProductsWithSkipErrorEntries] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->see("row(s): 1, 2, 3, 4, 5, 6, 7, 8, 9, 10", "#import_validation_messages .import-error-list"); // stepKey: seeTenImportError
		$I->comment("Import products with \"Stop on Error\" and \"Allowed Errors Count\" equals 5");
		$I->comment("Entering Action Group [importProductsWithAllowedErrorsCountFive] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProductsWithAllowedErrorsCountFive
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProductsWithAllowedErrorsCountFive
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProductsWithAllowedErrorsCountFive
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProductsWithAllowedErrorsCountFive
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProductsWithAllowedErrorsCountFive
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportProductsWithAllowedErrorsCountFive
		$I->fillField("#basic_behavior_allowed_error_count", "5"); // stepKey: fillAllowedErrorsCountFieldImportProductsWithAllowedErrorsCountFive
		$I->attachFile("#import_file", "catalog_product_err_img.csv"); // stepKey: attachFileForImportImportProductsWithAllowedErrorsCountFive
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProductsWithAllowedErrorsCountFive
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductsWithAllowedErrorsCountFiveWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForValidationNoticeMessageImportProductsWithAllowedErrorsCountFive
		$I->see("Checked rows: 10, checked entities: 10, invalid rows: 0, total errors: 0", "#import_validation_messages .message-notice"); // stepKey: seeValidationNoticeMessageImportProductsWithAllowedErrorsCountFive
		$I->see("File is valid! To start import process press \"Import\" button", "#import_validation_messages .message-success"); // stepKey: seeValidationMessageImportProductsWithAllowedErrorsCountFive
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProductsWithAllowedErrorsCountFive
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductsWithAllowedErrorsCountFiveWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProductsWithAllowedErrorsCountFive
		$I->see("Following Error(s) has been occurred during importing process", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProductsWithAllowedErrorsCountFive
		$I->see("Maximum error count has been reached or system error is occurred!", "#import_validation_messages .message-error"); // stepKey: seeImportMessageImportProductsWithAllowedErrorsCountFive
		$I->comment("Exiting Action Group [importProductsWithAllowedErrorsCountFive] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->see("row(s): 1, 2, 3, 4, 5, 6", "#import_validation_messages .import-error-list"); // stepKey: seeAboutFiveImportError
		$I->comment("Import products with \"Stop on Error\" and \"Allowed Errors Count\" equals 11");
		$I->comment("Entering Action Group [importProductsWithAllowedErrorsCountEleven] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProductsWithAllowedErrorsCountEleven
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProductsWithAllowedErrorsCountEleven
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProductsWithAllowedErrorsCountEleven
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProductsWithAllowedErrorsCountEleven
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProductsWithAllowedErrorsCountEleven
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportProductsWithAllowedErrorsCountEleven
		$I->fillField("#basic_behavior_allowed_error_count", "11"); // stepKey: fillAllowedErrorsCountFieldImportProductsWithAllowedErrorsCountEleven
		$I->attachFile("#import_file", "catalog_product_err_img.csv"); // stepKey: attachFileForImportImportProductsWithAllowedErrorsCountEleven
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProductsWithAllowedErrorsCountEleven
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductsWithAllowedErrorsCountElevenWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForValidationNoticeMessageImportProductsWithAllowedErrorsCountEleven
		$I->see("Checked rows: 10, checked entities: 10, invalid rows: 0, total errors: 0", "#import_validation_messages .message-notice"); // stepKey: seeValidationNoticeMessageImportProductsWithAllowedErrorsCountEleven
		$I->see("File is valid! To start import process press \"Import\" button", "#import_validation_messages .message-success"); // stepKey: seeValidationMessageImportProductsWithAllowedErrorsCountEleven
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProductsWithAllowedErrorsCountEleven
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductsWithAllowedErrorsCountElevenWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProductsWithAllowedErrorsCountEleven
		$I->see("Created: 0, Updated: 10, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProductsWithAllowedErrorsCountEleven
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportProductsWithAllowedErrorsCountEleven
		$I->comment("Exiting Action Group [importProductsWithAllowedErrorsCountEleven] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->see("row(s): 1, 2, 3, 4, 5, 6, 7, 8, 9, 10", "#import_validation_messages .import-error-list"); // stepKey: seeAboutTenImportError
	}
}
