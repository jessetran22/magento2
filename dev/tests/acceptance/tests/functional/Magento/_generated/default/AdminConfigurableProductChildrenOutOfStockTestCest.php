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
 * @Title("MC-181: Configurable Product goes 'Out of Stock' if all associated Simple Products are 'Out of Stock'")
 * @Description("Configurable Product goes 'Out of Stock' if all associated Simple Products are 'Out of Stock'<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableProductOutOfStockTest/AdminConfigurableProductChildrenOutOfStockTest.xml<br>")
 * @TestCaseId("MC-181")
 * @group ConfigurableProduct
 */
class AdminConfigurableProductChildrenOutOfStockTestCest
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
		$I->comment("TODO: This should be converted to an actionGroup once MQE-993 is fixed.");
		$I->comment("Create the category to put the product in");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product based on the data in the /data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("log in");
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
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Product visibility when in stock/out of stock"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableProductChildrenOutOfStockTest(AcceptanceTester $I)
	{
		$I->comment("Check to make sure that the configurable product shows up as in stock");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontLoad
		$I->see("IN STOCK", ".stock"); // stepKey: checkForOutOfStock
		$I->comment("Find the first simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialWaitForPageLoad
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-simple-product" . msq("ApiSimpleOne")); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFiltersToBeApplied
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Edit the quantity of the simple first product as 0");
		$I->fillField(".admin__field[data-index=qty] input", "0"); // stepKey: fillProductQuantity
		$I->comment("Entering Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Check to make sure that the configurable product shows up as in stock");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontLoad2
		$I->see("IN STOCK", ".stock"); // stepKey: checkForOutOfStock2
		$I->comment("Find the second simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage2
		$I->comment("Exiting Action Group [visitAdminProductPage2] AdminOpenProductIndexPageActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitial2WaitForPageLoad
		$I->comment("Entering Action Group [findCreatedProduct2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct2
		$I->fillField("input.admin__control-text[name='sku']", "api-simple-product-two" . msq("ApiSimpleTwo")); // stepKey: fillProductSkuFilterFindCreatedProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProduct2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct2
		$I->comment("Exiting Action Group [findCreatedProduct2] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFiltersToBeApplied2
		$I->comment("Entering Action Group [clickOnProductPage2] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage2
		$I->comment("Exiting Action Group [clickOnProductPage2] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Edit the quantity of the second simple product as 0");
		$I->fillField(".admin__field[data-index=qty] input", "0"); // stepKey: fillProductQuantity2
		$I->comment("Entering Action Group [clickSaveProduct2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveProduct2
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveProduct2
		$I->comment("Exiting Action Group [clickSaveProduct2] AdminProductFormSaveActionGroup");
		$I->comment("Check to make sure that the configurable product shows up as out of stock");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . "2.html"); // stepKey: goToConfigProductPage3
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontLoad3
		$I->see("OUT OF STOCK", ".stock"); // stepKey: checkForOutOfStock3
	}
}
