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
 * @Title("[NO TESTCASEID]: Update Bundle product via import")
 * @Description("Check that Bundle products are displaying on the storefront after updating product via importing CSV<h3>Test files</h3>app/code/Magento/BundleImportExport/Test/Mftf/Test/UpdateBundleProductViaImportTest.xml<br>")
 * @group importExport
 */
class UpdateBundleProductViaImportTestCest
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
		$I->comment("Delete products created via import");
		$I->comment("Entering Action Group [deleteBundleProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundleProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteBundleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundleProduct
		$I->fillField("input.admin__control-text[name='sku']", "Bundle"); // stepKey: fillProductSkuFilterDeleteBundleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleProductWaitForPageLoad
		$I->see("Bundle", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundleProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundleProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundleProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteBundleProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteBundleProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteBundleProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteBundleProduct
		$I->comment("Exiting Action Group [deleteBundleProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteSimpleProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSimpleProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSimpleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", "Simple"); // stepKey: fillProductSkuFilterDeleteSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSimpleProductWaitForPageLoad
		$I->see("Simple", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSimpleProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSimpleProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSimpleProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSimpleProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSimpleProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteSimpleProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteSimpleProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSimpleProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSimpleProduct
		$I->comment("Exiting Action Group [deleteSimpleProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Update Bundle product via import"})
	 * @Features({"BundleImportExport"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function UpdateBundleProductViaImportTest(AcceptanceTester $I)
	{
		$I->comment("Create Bundle product via import");
		$I->comment("Entering Action Group [adminImportProductsCreate] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProductsCreate
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProductsCreate
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProductsCreate
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProductsCreate
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProductsCreate
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProductsCreate
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProductsCreate
		$I->attachFile("#import_file", "catalog_product_import_bundle.csv"); // stepKey: attachFileForImportAdminImportProductsCreate
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProductsCreate
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsCreateWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProductsCreate
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductsCreateWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProductsCreate
		$I->see("Created: 2, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProductsCreate
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProductsCreate
		$I->comment("Exiting Action Group [adminImportProductsCreate] AdminImportProductsActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [indexerReindexAfterCreate] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersIndexerReindexAfterCreate = $I->magentoCLI("indexer:reindex", 60, "catalog_product_price"); // stepKey: reindexSpecifiedIndexersIndexerReindexAfterCreate
		$I->comment($reindexSpecifiedIndexersIndexerReindexAfterCreate);
		$I->comment("Exiting Action Group [indexerReindexAfterCreate] CliIndexerReindexActionGroup");
		$I->comment("Check Bundle product is visible on the storefront");
		$I->comment("Entering Action Group [openCategoryPageAfterCreation] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryPageAfterCreation
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryPageAfterCreation
		$I->click("//nav//a[span[contains(., 'New')]]"); // stepKey: toCategoryOpenCategoryPageAfterCreation
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryPageAfterCreationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryPageAfterCreation
		$I->comment("Exiting Action Group [openCategoryPageAfterCreation] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertBundleProductInStockAfterCreation] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'Bundle')]", 30); // stepKey: assertProductNameAssertBundleProductInStockAfterCreation
		$I->comment("Exiting Action Group [assertBundleProductInStockAfterCreation] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Update Bundle product via import");
		$I->comment("Entering Action Group [adminImportProductsUpdate] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProductsUpdate
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProductsUpdate
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProductsUpdate
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProductsUpdate
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProductsUpdate
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProductsUpdate
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProductsUpdate
		$I->attachFile("#import_file", "catalog_product_import_bundle.csv"); // stepKey: attachFileForImportAdminImportProductsUpdate
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProductsUpdate
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsUpdateWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProductsUpdate
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductsUpdateWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProductsUpdate
		$I->see("Created: 0, Updated: 2, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProductsUpdate
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProductsUpdate
		$I->comment("Exiting Action Group [adminImportProductsUpdate] AdminImportProductsActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Check Bundle product is still visible on the storefront");
		$I->comment("Entering Action Group [openCategoryPageAfterUpdate] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryPageAfterUpdate
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryPageAfterUpdate
		$I->click("//nav//a[span[contains(., 'New')]]"); // stepKey: toCategoryOpenCategoryPageAfterUpdate
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryPageAfterUpdateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryPageAfterUpdate
		$I->comment("Exiting Action Group [openCategoryPageAfterUpdate] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertBundleProductInStockAfterUpdate] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'Bundle')]", 30); // stepKey: assertProductNameAssertBundleProductInStockAfterUpdate
		$I->comment("Exiting Action Group [assertBundleProductInStockAfterUpdate] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
	}
}
