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
 * @Title("MC-21461: Set datetime attribute to product")
 * @Description("Admin should be able to specify datetime attribute to product and find by them in product grid<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateSimpleProductWithDatetimeAttributeTest.xml<br>")
 * @TestCaseId("MC-21461")
 * @group catalog
 */
class AdminCreateSimpleProductWithDatetimeAttributeTestCest
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
		$I->deleteEntity("createDatetimeAttribute", "hook"); // stepKey: deleteDatetimeAttribute
		$I->comment("Entering Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteCreatedProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCreatedProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteCreatedProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteCreatedProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteCreatedProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteCreatedProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteCreatedProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteCreatedProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteCreatedProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteCreatedProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCreatedProduct
		$I->comment("Exiting Action Group [deleteCreatedProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnProductIndexPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnProductIndexPageWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Datetime product attributes support"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateSimpleProductWithDatetimeAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Generate default value");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateDefaultValue = $date->format("m/j/Y g:i A");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateDefaultGridValue = $date->format("M j, Y g:i:00 A");

		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 minute"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$generateFilterToDate = $date->format("m/j/Y g:i A");

		$I->comment("Create new datetime product attribute");
		$createDatetimeAttributeFields['default_value'] = $generateDefaultValue;
		$I->createEntity("createDatetimeAttribute", "test", "DatetimeProductAttribute", [], $createDatetimeAttributeFields); // stepKey: createDatetimeAttribute
		$I->comment("Open the new simple product page");
		$I->comment("Entering Action Group [openNewProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageOpenNewProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewProductPage
		$I->comment("Exiting Action Group [openNewProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Entering Action Group [fillDefaultProductFields] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillDefaultProductFields
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillDefaultProductFields
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillDefaultProductFields
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillDefaultProductFields
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillDefaultProductFields
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillDefaultProductFields
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillDefaultProductFieldsWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillDefaultProductFields
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillDefaultProductFields
		$I->comment("Exiting Action Group [fillDefaultProductFields] FillMainProductFormActionGroup");
		$I->comment("Add datetime attribute");
		$I->comment("Entering Action Group [addDatetimeAttribute] AddProductAttributeInProductModalActionGroup");
		$I->click("#addAttribute"); // stepKey: addAttributeAddDatetimeAttribute
		$I->waitForPageLoad(30); // stepKey: addAttributeAddDatetimeAttributeWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_add_attribute_modal .action-clear", ".product_form_product_form_add_attribute_modal .action-clear", true); // stepKey: clearFiltersAddDatetimeAttribute
		$I->waitForPageLoad(30); // stepKey: clearFiltersAddDatetimeAttributeWaitForPageLoad
		$I->click(".product_form_product_form_add_attribute_modal button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddDatetimeAttribute
		$I->waitForPageLoad(30); // stepKey: clickFiltersAddDatetimeAttributeWaitForPageLoad
		$I->fillField(".product_form_product_form_add_attribute_modal input[name='attribute_code']", $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test')); // stepKey: fillCodeAddDatetimeAttribute
		$I->click(".product_form_product_form_add_attribute_modal .admin__data-grid-filters-footer .action-secondary"); // stepKey: clickApplyAddDatetimeAttribute
		$I->waitForPageLoad(30); // stepKey: clickApplyAddDatetimeAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAddDatetimeAttribute
		$I->checkOption(".product_form_product_form_add_attribute_modal .data-grid-checkbox-cell input"); // stepKey: checkAttributeAddDatetimeAttribute
		$I->click(".product_form_product_form_add_attribute_modal .page-main-actions .action-primary"); // stepKey: addSelectedAddDatetimeAttribute
		$I->waitForPageLoad(30); // stepKey: addSelectedAddDatetimeAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [addDatetimeAttribute] AddProductAttributeInProductModalActionGroup");
		$I->comment("Save the product");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->reloadPage(); // stepKey: reloadProductEditPage
		$I->comment("Check default value");
		$I->waitForElementVisible("div[data-index='attributes']", 30); // stepKey: waitAttributesSectionAppears
		$I->waitForPageLoad(30); // stepKey: waitAttributesSectionAppearsWaitForPageLoad
		$I->conditionalClick("div[data-index='attributes']", "div[data-index='" . $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test') . "'] .admin__field-control input", false); // stepKey: openAttributesSection
		$I->scrollTo("div[data-index='attributes']"); // stepKey: scrollToAttributesSection
		$I->waitForPageLoad(30); // stepKey: scrollToAttributesSectionWaitForPageLoad
		$I->waitForElementVisible("div[data-index='" . $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test') . "'] .admin__field-control input", 30); // stepKey: waitForSlideOutAttributes
		$I->seeInField("div[data-index='" . $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test') . "'] .admin__field-control input", "$generateDefaultValue"); // stepKey: checkDefaultValue
		$I->comment("Check datetime grid filter");
		$I->comment("Entering Action Group [goToAdminProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToAdminProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToAdminProductIndexPage
		$I->comment("Exiting Action Group [goToAdminProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFilters
		$I->waitForPageLoad(30); // stepKey: openProductFiltersWaitForPageLoad
		$I->fillField("input.admin__control-text[name='" . $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test') . "[from]']", $generateDefaultValue); // stepKey: fillProductDatetimeFromFilter
		$I->fillField("input.admin__control-text[name='" . $I->retrieveEntityField('createDatetimeAttribute', 'attribute_code', 'test') . "[to]']", $generateFilterToDate); // stepKey: fillProductDatetimeToFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersWaitForPageLoad
		$I->see("testProductName" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Name')]/preceding-sibling::th) +1 ]"); // stepKey: checkAppliedDatetimeFilter
		$I->see($generateDefaultGridValue, "//tbody/tr[td[*[text()[normalize-space()='testProductName" . msq("_defaultProduct") . "']]]]"); // stepKey: checkDefaultValueInGrid
	}
}
