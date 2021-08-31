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
 * @Title("MC-10887: Delete Product Attribute")
 * @Description("Admin should able to delete a product attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteProductAttributeTest.xml<br>")
 * @TestCaseId("MC-10887")
 * @group mtf_migrated
 */
class DeleteProductAttributeTestCest
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
		$I->createEntity("createProductAttribute", "hook", "productAttributeWysiwyg", [], []); // stepKey: createProductAttribute
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
	 * @Features({"Catalog"})
	 * @Stories({"Product attributes"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test')); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test') . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test'), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test') . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeSuccess
		$I->comment("Exiting Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->comment("Assert the product attribute is not in the grid by Attribute code");
		$I->comment("Entering Action Group [filterByAttributeCode] FilterProductAttributeByAttributeCodeActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridFilterByAttributeCode
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridFilterByAttributeCodeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test')); // stepKey: setAttributeCodeFilterByAttributeCode
		$I->waitForPageLoad(30); // stepKey: waitForUserInputFilterByAttributeCode
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridFilterByAttributeCode
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridFilterByAttributeCodeWaitForPageLoad
		$I->comment("Exiting Action Group [filterByAttributeCode] FilterProductAttributeByAttributeCodeActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage
		$I->comment("Assert the product attribute is not in the grid by Default Label");
		$I->comment("Entering Action Group [filterByDefaultLabel] FilterProductAttributeByDefaultLabelActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridFilterByDefaultLabel
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridFilterByDefaultLabelWaitForPageLoad
		$I->fillField("#attributeGrid_filter_frontend_label", $I->retrieveEntityField('createProductAttribute', 'default_frontend_label', 'test')); // stepKey: setDefaultLabelFilterByDefaultLabel
		$I->waitForPageLoad(30); // stepKey: waitForUserInputFilterByDefaultLabel
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridFilterByDefaultLabel
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridFilterByDefaultLabelWaitForPageLoad
		$I->comment("Exiting Action Group [filterByDefaultLabel] FilterProductAttributeByDefaultLabelActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage2
		$I->comment("Go to the Catalog > Products page and create Simple Product");
		$I->comment("Entering Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductList
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductList
		$I->comment("Exiting Action Group [amOnProductList] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [chooseAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownChooseAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownChooseAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductChooseAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadChooseAddSimpleProduct
		$I->comment("Exiting Action Group [chooseAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Press Add Attribute button");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtn
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeAdded
		$I->comment("Filter By Attribute Label on Add Attribute Page");
		$I->click("//div[@class='data-grid-filters-action-wrap']/button"); // stepKey: clickOnFilter
		$I->waitForPageLoad(30); // stepKey: clickOnFilterWaitForPageLoad
		$I->comment("Entering Action Group [filterByAttributeLabel] FilterProductAttributeByAttributeLabelActionGroup");
		$I->fillField("//input[@name='frontend_label']", $I->retrieveEntityField('createProductAttribute', 'default_frontend_label', 'test')); // stepKey: setAttributeLabelFilterByAttributeLabel
		$I->waitForPageLoad(30); // stepKey: waitForUserInputFilterByAttributeLabel
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridFilterByAttributeLabel
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridFilterByAttributeLabelWaitForPageLoad
		$I->comment("Exiting Action Group [filterByAttributeLabel] FilterProductAttributeByAttributeLabelActionGroup");
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage3
		$I->comment("Filter By Attribute Code on Export > Products page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToSystemExport
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOption
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisible
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFilter
		$I->waitForPageLoad(30); // stepKey: resetFilterWaitForPageLoad
		$I->fillField("#export_filter_grid_filter_attribute_code", $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test')); // stepKey: setAttributeCode
		$I->waitForPageLoad(30); // stepKey: waitForUserInput
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeWaitForPageLoad
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessage4
	}
}
