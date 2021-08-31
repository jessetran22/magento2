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
 * @Title("MC-8902: Promote Multiple Products (Simple, Configurable) as Up-Sell Products")
 * @Description("Login as admin and add simple and configurable Products as Up-Sell products<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminNavigateMultipleUpSellProductsTest.xml<br>")
 * @TestCaseId("MC-8902")
 * @group mtf_migrated
 */
class AdminNavigateMultipleUpSellProductsTestCest
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
		$I->comment("Create Simple Products");
		$I->createEntity("createCategory1", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory1
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCategory2", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory2
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct", ["createCategory2"], []); // stepKey: createSimpleProduct1
		$I->comment("Create the configurable product with product Attribute options");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("delete", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: delete
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout as admin");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete created data");
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCategory1", "hook"); // stepKey: deleteSubCategory1
		$I->deleteEntity("createCategory2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deletecreateConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deletecreateConfigChildProduct1
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Up Sell products"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminNavigateMultipleUpSellProductsTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Index Page");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Select SimpleProduct");
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: openFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->comment("Add SimpleProduct1 and ConfigProduct as Up sell products");
		$I->click(".admin__collapsible-block-wrapper[data-index='related']"); // stepKey: clickOnRelatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnRelatedProductsWaitForPageLoad
		$I->click("button[data-index='button_upsell']"); // stepKey: clickOnAddUpSellProducts
		$I->waitForPageLoad(30); // stepKey: clickOnAddUpSellProductsWaitForPageLoad
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySku2ActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductToLoad
		$I->checkOption("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: selectTheSimpleProduct2
		$I->click("//aside[contains(@class, 'upsell_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addSelectedProduct
		$I->waitForPageLoad(30); // stepKey: addSelectedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToBeAdded
		$I->click("button[data-index='button_upsell']"); // stepKey: clickOnAddUpSellProductsButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddUpSellProductsButtonWaitForPageLoad
		$I->comment("Entering Action Group [filterConfigurableProduct] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterConfigurableProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterConfigurableProduct
		$I->comment("Exiting Action Group [filterConfigurableProduct] FilterProductGridBySku2ActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheConfigProductToLoad
		$I->checkOption("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: selectTheConfigProduct
		$I->click("//aside[contains(@class, 'upsell_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addSelectedProductButton
		$I->waitForPageLoad(30); // stepKey: addSelectedProductButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigProductToBeAdded
		$I->click(".admin__collapsible-block-wrapper[data-index='related']"); // stepKey: clickOnRelatedProducts1
		$I->waitForPageLoad(30); // stepKey: clickOnRelatedProducts1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoading1
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Go to Product Index Page");
		$I->click("#back"); // stepKey: clickOnBackButton
		$I->waitForPageLoad(30); // stepKey: clickOnBackButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsToBeLoaded
		$I->comment("Select Configurable Product");
		$I->comment("Entering Action Group [findConfigProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindConfigProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindConfigProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindConfigProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFindConfigProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindConfigProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindConfigProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindConfigProduct
		$I->comment("Exiting Action Group [findConfigProduct] FilterProductGridBySkuActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigProduct', 'sku', 'test') . "']]"); // stepKey: openConfigProduct
		$I->waitForPageLoad(30); // stepKey: waitForConfigProductToLoad
		$I->comment("Add  SimpleProduct1 as Up Sell Product");
		$I->click(".admin__collapsible-block-wrapper[data-index='related']"); // stepKey: clickOnRelatedProductsHeader
		$I->waitForPageLoad(30); // stepKey: clickOnRelatedProductsHeaderWaitForPageLoad
		$I->click("button[data-index='button_upsell']"); // stepKey: clickOnAddUpSellProductsButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAddUpSellProductsButton1WaitForPageLoad
		$I->comment("Entering Action Group [filterSimpleProduct2] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterSimpleProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterSimpleProduct2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterSimpleProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterSimpleProduct2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterSimpleProduct2
		$I->comment("Exiting Action Group [filterSimpleProduct2] FilterProductGridBySku2ActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheSimpleProduct2ToBeLoaded
		$I->checkOption("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: selectSimpleProduct1
		$I->click("//aside[contains(@class, 'upsell_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addSimpleProduct2
		$I->waitForPageLoad(30); // stepKey: addSimpleProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductToBeAdded
		$I->scrollTo("#save-button"); // stepKey: scrollToTheSaveButton
		$I->waitForPageLoad(30); // stepKey: scrollToTheSaveButtonWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton1
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoading2
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown1
		$I->waitForPageLoad(30); // stepKey: waitForUpdatesTobeSaved1
		$I->comment("Go to SimpleProduct store front page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSimpleProductFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProduct
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductName
		$I->scrollTo("#block-upsell-heading"); // stepKey: scrollToTheUpSellHeading
		$I->comment("Verify Up Sell Products displayed in SimpleProduct page");
		$I->see("We found other products you might like!", "#block-upsell-heading"); // stepKey: seeTheUpSellHeading
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), "div.upsell .product-item-name"); // stepKey: seeSimpleProduct1
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "div.upsell .product-item-name"); // stepKey: seeConfigProduct
		$I->comment("Go to Config Product store front page");
		$I->amOnPage($I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToConfigProductFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigProductToBeLoaded
		$I->scrollTo("#block-upsell-heading"); // stepKey: scrollToTheUpSellHeading1
		$I->comment("Verify Up Sell Products displayed in ConfigProduct page");
		$I->see("We found other products you might like!", "#block-upsell-heading"); // stepKey: seeTheUpSellHeading1
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), "div.upsell .product-item-name"); // stepKey: seeSimpleProduct2
		$I->comment("Go to SimpleProduct1 store front page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSimpleProduct1FrontPage
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProduct1ToBeLoaded
		$I->comment("Verify No Up Sell Products displayed in SimplProduct1 page");
		$I->dontSee("We found other products you might like!", "#block-upsell-heading"); // stepKey: dontSeeTheUpSellHeading1
	}
}
