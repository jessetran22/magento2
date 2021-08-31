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
 * @Title("MC-14061: Admin should not be able to delete product attribute used in configurable product")
 * @Description("Admin should not be able to delete product attribute used in configurable product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/DeleteUsedInConfigurableProductAttributeTest.xml<br>")
 * @TestCaseId("MC-14061")
 * @group Catalog
 * @group mtf_migrated
 */
class DeleteUsedInConfigurableProductAttributeTestCest
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
		$I->comment("Create category");
		$I->createEntity("categoryHandle", "hook", "SimpleSubCategory", [], []); // stepKey: categoryHandle
		$I->comment("Create base configurable product");
		$I->createEntity("baseConfigProductHandle", "hook", "BaseConfigurableProduct", ["categoryHandle"], []); // stepKey: baseConfigProductHandle
		$I->comment("Create Dropdown Product Attribute");
		$I->createEntity("productAttributeHandle", "hook", "productDropDownAttribute", [], []); // stepKey: productAttributeHandle
		$I->comment("Create attribute options");
		$I->createEntity("productAttributeOption1Handle", "hook", "productAttributeOption1", ["productAttributeHandle"], []); // stepKey: productAttributeOption1Handle
		$I->createEntity("productAttributeOption2Handle", "hook", "productAttributeOption2", ["productAttributeHandle"], []); // stepKey: productAttributeOption2Handle
		$I->comment("Add to attribute to Default attribute set");
		$I->createEntity("addToAttributeSetHandle", "hook", "AddToDefaultSet", ["productAttributeHandle"], []); // stepKey: addToAttributeSetHandle
		$I->comment("Get handle of the attribute options");
		$I->getEntity("getAttributeOption1Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 1); // stepKey: getAttributeOption1Handle
		$I->getEntity("getAttributeOption2Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 2); // stepKey: getAttributeOption2Handle
		$I->comment("Create configurable product with the options");
		$I->createEntity("configProductOptionHandle", "hook", "ConfigurableProductTwoOptions", ["baseConfigProductHandle", "productAttributeHandle", "getAttributeOption1Handle", "getAttributeOption2Handle"], []); // stepKey: configProductOptionHandle
		$I->comment("Login As Admin");
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
		$I->comment("Delete the configurable product created in the before block");
		$I->deleteEntity("baseConfigProductHandle", "hook"); // stepKey: deleteConfig
		$I->comment("Delete the category created in the before block");
		$I->deleteEntity("categoryHandle", "hook"); // stepKey: deleteCategory
		$I->comment("Delete configurable product attribute created in the before block");
		$I->deleteEntity("productAttributeHandle", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Logout");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Delete product attribute"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteUsedInConfigurableProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Go to Stores > Attributes > Products. Search and select the product attribute that was used to create the configurable product");
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test')); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test') . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Click Delete Attribute button");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Should see error message: This attribute is used in configurable products.");
		$I->comment("Entering Action Group [assertAttributeDeletionErrorMessage] AssertAttributeDeletionErrorMessageActionGroup");
		$I->waitForElementVisible(".message.message-error.error", 30); // stepKey: waitForErrorMessageAssertAttributeDeletionErrorMessage
		$I->see("This attribute is used in configurable products.", ".message.message-error.error"); // stepKey: deleteProductAttributeFailureMessageAssertAttributeDeletionErrorMessage
		$I->comment("Exiting Action Group [assertAttributeDeletionErrorMessage] AssertAttributeDeletionErrorMessageActionGroup");
		$I->comment("Go back to the product attribute grid. Should see the product attribute in the grid");
		$I->comment("Entering Action Group [searchAttributeByCodeOnProductAttributeGrid] SearchAttributeByCodeOnProductAttributeGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadSearchAttributeByCodeOnProductAttributeGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridSearchAttributeByCodeOnProductAttributeGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadSearchAttributeByCodeOnProductAttributeGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test')); // stepKey: setAttributeCodeSearchAttributeByCodeOnProductAttributeGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridSearchAttributeByCodeOnProductAttributeGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearSearchAttributeByCodeOnProductAttributeGrid
		$I->see($I->retrieveEntityField('productAttributeHandle', 'attribute_code', 'test'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridSearchAttributeByCodeOnProductAttributeGrid
		$I->comment("Exiting Action Group [searchAttributeByCodeOnProductAttributeGrid] SearchAttributeByCodeOnProductAttributeGridActionGroup");
		$I->comment("Go to the Catalog > Products page and search configurable product created in before block.");
		$I->comment("Entering Action Group [searchForProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProductOnBackend
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProductOnBackend
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProductOnBackend
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProductOnBackend
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProductOnBackendWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('baseConfigProductHandle', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProductOnBackend
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProductOnBackend
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProductOnBackendWaitForPageLoad
		$I->comment("Exiting Action Group [searchForProductOnBackend] SearchForProductOnBackendActionGroup");
		$I->comment("Should see the product attributes as expected");
		$I->comment("Entering Action Group [assertProductAttributePresenceInCatalogProductGrid] AssertProductAttributePresenceInCatalogProductGridActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCatalogProductGridPageLoadAssertProductAttributePresenceInCatalogProductGrid
		$I->seeElement("//div[@data-role='grid-wrapper']//span[@class='data-grid-cell-content' and contains(text(), '" . $I->retrieveEntityField('productAttributeHandle', 'label', 'test') . "')]/parent::*"); // stepKey: seeAttributeInHeadersAssertProductAttributePresenceInCatalogProductGrid
		$I->comment("Exiting Action Group [assertProductAttributePresenceInCatalogProductGrid] AssertProductAttributePresenceInCatalogProductGridActionGroup");
	}
}
