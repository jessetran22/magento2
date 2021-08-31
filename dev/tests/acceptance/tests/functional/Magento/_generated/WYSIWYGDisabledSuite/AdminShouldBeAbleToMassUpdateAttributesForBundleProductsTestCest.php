<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-219: Admin should be able to mass update attributes for bundle products")
 * @Description("Admin should be able to mass update attributes for bundle products<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminShouldBeAbleToMassUpdateAttributesForBundleProductsTest.xml<br>")
 * @TestCaseId("MC-219")
 * @group bundle
 * @group WYSIWYGDisabled
 */
class AdminShouldBeAbleToMassUpdateAttributesForBundleProductsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Create Fixed Bundle Product");
		$I->createEntity("createFixedBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createFixedBundleProduct
		$I->comment("Create DropDown Bundle Option");
		$I->createEntity("createBundleOption", "hook", "DropDownBundleOption", ["createFixedBundleProduct"], []); // stepKey: createBundleOption
		$I->comment("Link Simple Product");
		$I->createEntity("createNewBundleLink", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createBundleOption", "createSimpleProduct"], []); // stepKey: createNewBundleLink
		$runCronIndex = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Simple Product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete Fixed Bundle Product");
		$I->deleteEntity("createFixedBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->comment("Clear Filter");
		$I->comment("Entering Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->comment("Log Out Admin");
		$I->comment("Entering Action Group [logoutAsAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsAdmin
		$I->comment("Exiting Action Group [logoutAsAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Bundle"})
	 * @Stories({"Admin list bundle products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminShouldBeAbleToMassUpdateAttributesForBundleProductsTest(AcceptanceTester $I)
	{
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to Catalog -> Catalog -> Products and Search created product in precondition and choose it");
		$I->comment("Entering Action Group [searchProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createFixedBundleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Choose \"Update attributes\" and Change any product data");
		$I->comment("Entering Action Group [updateProductAttribute] AdminUpdateProductNameAndDescriptionAttributes");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckboxUpdateProductAttribute
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownUpdateProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickDropdownUpdateProductAttributeWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionUpdateProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickOptionUpdateProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForUploadPageUpdateProductAttribute
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeAttributePageEditUrlUpdateProductAttribute
		$I->click("#toggle_name"); // stepKey: clickToChangeNameUpdateProductAttribute
		$I->fillField("#name", "New Bundle Product Name" . msq("UpdateAttributeNameAndDescription")); // stepKey: fillFieldNameUpdateProductAttribute
		$I->scrollTo("#toggle_description", 0, -80); // stepKey: scrollToDescriptionUpdateProductAttribute
		$I->click("#toggle_description"); // stepKey: clickToChangeDescriptionUpdateProductAttribute
		$I->fillField("#description", "This is the description" . msq("UpdateAttributeNameAndDescription")); // stepKey: fillFieldDescriptionUpdateProductAttribute
		$I->click("button[title='Save']"); // stepKey: saveUpdateProductAttribute
		$I->waitForPageLoad(30); // stepKey: saveUpdateProductAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitVisibleSuccessMessageUpdateProductAttribute
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: seeSuccessMessageUpdateProductAttribute
		$I->comment("Exiting Action Group [updateProductAttribute] AdminUpdateProductNameAndDescriptionAttributes");
		$I->comment("Start message queue for product attribute consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start product_action_attribute.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Search for a product with a new name and Open Product");
		$I->comment("Entering Action Group [searchWithNewProductName] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchWithNewProductName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchWithNewProductNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersSearchWithNewProductName
		$I->fillField("input.admin__control-text[name='name']", "New Bundle Product Name" . msq("UpdateAttributeNameAndDescription")); // stepKey: fillProductNameFilterSearchWithNewProductName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersSearchWithNewProductName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersSearchWithNewProductNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadSearchWithNewProductName
		$I->comment("Exiting Action Group [searchWithNewProductName] FilterProductGridByNameActionGroup");
		$I->comment("Entering Action Group [openProductPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createFixedBundleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createFixedBundleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenEditProductOnBackendActionGroup");
		$I->comment("Assert product name and description");
		$I->comment("Entering Action Group [assertProductName] AssertProductNameInProductEditFormActionGroup");
		$I->seeInField(".admin__field[data-index=name] input", "New Bundle Product Name" . msq("UpdateAttributeNameAndDescription")); // stepKey: seeProductNameOnEditProductPageAssertProductName
		$I->comment("Exiting Action Group [assertProductName] AssertProductNameInProductEditFormActionGroup");
		$I->comment("Entering Action Group [assertProductDescription] AssertProductDescriptionInProductEditFormActionGroup");
		$I->conditionalClick("div[data-index='content']", "div[data-index='content']._show", false); // stepKey: expandContentSectionAssertProductDescription
		$I->waitForPageLoad(30); // stepKey: expandContentSectionAssertProductDescriptionWaitForPageLoad
		$I->seeInField("#product_form_description", "This is the description" . msq("UpdateAttributeNameAndDescription")); // stepKey: seeProductDescriptionAssertProductDescription
		$I->comment("Exiting Action Group [assertProductDescription] AssertProductDescriptionInProductEditFormActionGroup");
	}
}
