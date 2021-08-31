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
 * @Title("MAGETWO-98992: Cloning a product with duplicate URL key")
 * @Description("Check product cloning with duplicate URL key<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCloneProductWithDuplicateUrlTest.xml<br>")
 * @TestCaseId("MAGETWO-98992")
 * @group catalog
 */
class AdminCloneProductWithDuplicateUrlTestCest
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
		$I->comment("Create category and product");
		$I->comment("Create category and product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteAllDuplicateProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterDeleteAllDuplicateProducts
		$I->fillField("input.admin__control-text[name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'hook')); // stepKey: fillProductNameFilterDeleteAllDuplicateProducts
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteAllDuplicateProducts
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteAllDuplicateProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllDuplicateProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllDuplicateProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllDuplicateProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteAllDuplicateProducts
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllDuplicateProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllDuplicateProductsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAllDuplicateProducts] DeleteAllDuplicateProductUsingProductGridActionGroup");
		$I->comment("Entering Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFiltersIfExistWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFiltersIfExist
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFiltersIfExistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetFiltersIfExist
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFiltersIfExist
		$I->comment("Exiting Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Product"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCloneProductWithDuplicateUrlTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
		$I->comment("Save and duplicated the product once");
		$I->comment("Save and duplicated the product once");
		$I->comment("Entering Action Group [saveAndDuplicateProductFormFirstTime] AdminFormSaveAndDuplicateActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndDuplicateProductFormFirstTime
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndDuplicateProductFormFirstTimeWaitForPageLoad
		$I->click("span[id='save_and_duplicate']"); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductFormFirstTime
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductFormFirstTimeWaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSaveSuccessSaveAndDuplicateProductFormFirstTime
		$I->see("You duplicated the product.", ".message.message-success.success"); // stepKey: assertDuplicateSuccessSaveAndDuplicateProductFormFirstTime
		$I->comment("Exiting Action Group [saveAndDuplicateProductFormFirstTime] AdminFormSaveAndDuplicateActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSEOSection
		$grabDuplicatedProductUrlKey = $I->grabValueFrom("input[name='product[url_key]']"); // stepKey: grabDuplicatedProductUrlKey
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test'), $grabDuplicatedProductUrlKey); // stepKey: assertDuplicatedProductUrlKey
		$I->assertStringContainsString("-1", $grabDuplicatedProductUrlKey); // stepKey: assertDuplicatedProductUrlKey1
		$I->comment("Add duplicated product to the simple product");
		$I->comment("Add duplicated product to the simple product");
		$I->comment("Entering Action Group [goToSimpleProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToSimpleProductPage
		$I->comment("Exiting Action Group [goToSimpleProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad1
		$I->comment("Entering Action Group [addCrossSellProduct] AddCrossSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddCrossSellProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddCrossSellProduct
		$I->click("button[data-index='button_crosssell']"); // stepKey: clickAddCrossSellButtonAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: clickAddCrossSellButtonAddCrossSellProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddCrossSellProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddCrossSellProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddCrossSellProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddCrossSellProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddCrossSellProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddCrossSellProductWaitForPageLoad
		$I->click(".product_form_product_form_related_crosssell_modal .action-primary"); // stepKey: addRelatedProductSelectedAddCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: waitForModalDisappearAddCrossSellProduct
		$I->comment("Exiting Action Group [addCrossSellProduct] AddCrossSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addUpSellProduct] AddUpSellProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddUpSellProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddUpSellProduct
		$I->click("button[data-index='button_upsell']"); // stepKey: clickAddRelatedProductButtonAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddUpSellProductWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_related_upsell_modal .admin__data-grid-header button[data-action='grid-filter-reset']", ".product_form_product_form_related_upsell_modal .admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddUpSellProductWaitForPageLoad
		$I->click(".product_form_product_form_related_upsell_modal button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddUpSellProduct
		$I->fillField(".product_form_product_form_related_upsell_modal input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddUpSellProduct
		$I->click(".product_form_product_form_related_upsell_modal button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddUpSellProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddUpSellProduct
		$I->click(".product_form_product_form_related_upsell_modal.modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddUpSellProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'product_form_product_form_related_upsell_modal')]//button/span[contains(text(), 'Add Selected Products')]"); // stepKey: addRelatedProductSelectedAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddUpSellProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddUpSellProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddUpSellProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1AddUpSellProduct
		$I->comment("Exiting Action Group [addUpSellProduct] AddUpSellProductBySkuActionGroup");
		$I->comment("Entering Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->conditionalClick(".fieldset-wrapper.admin__collapsible-block-wrapper[data-index='related']", "button[data-index='button_related']", false); // stepKey: openProductRUSSection
		$I->waitForPageLoad(30); // stepKey: openProductRUSSectionWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='related']//span[@data-index='sku']"); // stepKey: seeRelatedProduct
		$I->waitForPageLoad(30); // stepKey: seeRelatedProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='upsell']//span[@data-index='sku']"); // stepKey: seeUpSellProduct
		$I->waitForPageLoad(30); // stepKey: seeUpSellProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='crosssell']//span[@data-index='sku']"); // stepKey: seeCrossSellProduct
		$I->waitForPageLoad(30); // stepKey: seeCrossSellProductWaitForPageLoad
		$I->comment("Save and duplicated the product second time");
		$I->comment("Save and duplicated the product second time");
		$I->comment("Entering Action Group [goToProductEditPage1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage1
		$I->comment("Exiting Action Group [goToProductEditPage1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad2
		$I->comment("Entering Action Group [saveAndDuplicateProductFormSecondTime] AdminFormSaveAndDuplicateActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndDuplicateProductFormSecondTime
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndDuplicateProductFormSecondTimeWaitForPageLoad
		$I->click("span[id='save_and_duplicate']"); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductFormSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndDuplicateSaveAndDuplicateProductFormSecondTimeWaitForPageLoad
		$I->see("You saved the product.", ".message.message-success.success"); // stepKey: assertSaveSuccessSaveAndDuplicateProductFormSecondTime
		$I->see("You duplicated the product.", ".message.message-success.success"); // stepKey: assertDuplicateSuccessSaveAndDuplicateProductFormSecondTime
		$I->comment("Exiting Action Group [saveAndDuplicateProductFormSecondTime] AdminFormSaveAndDuplicateActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openProductSEOSection
		$I->waitForElementVisible("input[name='product[url_key]']", 30); // stepKey: waitForUrlKeyField
		$grabSecondDuplicatedProductUrlKey = $I->grabValueFrom("input[name='product[url_key]']"); // stepKey: grabSecondDuplicatedProductUrlKey
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test'), $grabSecondDuplicatedProductUrlKey); // stepKey: assertSecondDuplicatedProductUrlKey
		$I->assertStringContainsString("-2", $grabSecondDuplicatedProductUrlKey); // stepKey: assertSecondDuplicatedProductUrlKey1
		$I->conditionalClick(".fieldset-wrapper.admin__collapsible-block-wrapper[data-index='related']", "button[data-index='button_related']", false); // stepKey: openProductRUSSection1
		$I->waitForPageLoad(30); // stepKey: openProductRUSSection1WaitForPageLoad
		$I->waitForElementVisible("//div[@data-index='related']//span[@data-index='sku']", 30); // stepKey: waitForSelectedProductSku
		$I->waitForPageLoad(30); // stepKey: waitForSelectedProductSkuWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='related']//span[@data-index='sku']"); // stepKey: seeRelatedProductForDuplicated
		$I->waitForPageLoad(30); // stepKey: seeRelatedProductForDuplicatedWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='upsell']//span[@data-index='sku']"); // stepKey: seeUpSellProductForDuplicated
		$I->waitForPageLoad(30); // stepKey: seeUpSellProductForDuplicatedWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "-1", "//div[@data-index='crosssell']//span[@data-index='sku']"); // stepKey: seeCrossSellProductForDuplicated
		$I->waitForPageLoad(30); // stepKey: seeCrossSellProductForDuplicatedWaitForPageLoad
	}
}
