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
 * @Title("MC-28374: User should be able to use Quick Search to a configurable product's child products")
 * @Description("Use Quick Search to find a configurable product with enabled/disable children<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontQuickSearchConfigurableChildrenTest.xml<br>")
 * @TestCaseId("MC-28374")
 * @group catalogSearch
 * @group mtf_migrated
 */
class StorefrontQuickSearchConfigurableChildrenTestCest
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
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create blank AttributeSet");
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createProductAttribute", "hook", "hiddenDropdownAttributeWithOptions", [], []); // stepKey: createProductAttribute
		$I->createEntity("createProductAttributeOption", "hook", "productAttributeOption1", ["createProductAttribute"], []); // stepKey: createProductAttributeOption
		$I->comment("Assign attribute to set");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetPageGoToAttributeSetPage
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadGoToAttributeSetPage
		$I->comment("Exiting Action Group [goToAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->comment("Entering Action Group [openAttributeSetByName] GoToAttributeSetByNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonOpenAttributeSetByName
		$I->waitForPageLoad(30); // stepKey: clickResetButtonOpenAttributeSetByNameWaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'hook')); // stepKey: filterByNameOpenAttributeSetByName
		$I->click("#container button[title='Search']"); // stepKey: clickSearchOpenAttributeSetByName
		$I->waitForPageLoad(30); // stepKey: clickSearchOpenAttributeSetByNameWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowOpenAttributeSetByName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAttributeSetByName
		$I->comment("Exiting Action Group [openAttributeSetByName] GoToAttributeSetByNameActionGroup");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [savePage] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSavePage
		$I->waitForPageLoad(30); // stepKey: clickSaveSavePageWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSavePage
		$I->comment("Exiting Action Group [savePage] SaveAttributeSetActionGroup");
		$I->comment("Get the first option of the attribute we created");
		$I->getEntity("getAttributeOption", "hook", "ProductAttributeOptionGetter", ["createProductAttribute"], null, 1); // stepKey: getAttributeOption
		$I->comment("Create a simple product");
		$createSimpleProductFields['attribute_set_id'] = $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook');
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleOneHidden", ["createProductAttribute", "getAttributeOption"], $createSimpleProductFields, "all"); // stepKey: createSimpleProduct
		$I->updateEntity("createSimpleProduct", "hook", "ApiSimpleProductUpdateDescription",[]); // stepKey: updateSimpleProduct
		$I->comment("Create the configurable product");
		$createConfigurableProductFields['attribute_set_id'] = $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook');
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], $createConfigurableProductFields); // stepKey: createConfigurableProduct
		$I->comment("Create the configurable product option");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductOneOption", ["createConfigurableProduct", "createProductAttribute", "getAttributeOption"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createSimpleProduct"], []); // stepKey: createConfigProductAddChild
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Search Product on Storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontQuickSearchConfigurableChildrenTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createConfigurableProduct', 'name', 'test')); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [seeProductInGrid] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->see($I->retrieveEntityField('createConfigurableProduct', 'name', 'test'), "//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]"); // stepKey: seeProductNameSeeProductInGrid
		$I->comment("Exiting Action Group [seeProductInGrid] StorefrontQuickSearchSeeProductByNameActionGroup");
		$I->comment("Disable Child Product");
		$I->comment("Entering Action Group [openSimpleProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductOpenSimpleProduct
		$I->comment("Exiting Action Group [openSimpleProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [disableProduct] ToggleProductEnabledActionGroup");
		$I->click("input[name='product[status]']+label"); // stepKey: toggleEnabledDisableProduct
		$I->comment("Exiting Action Group [disableProduct] ToggleProductEnabledActionGroup");
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
		$I->comment("Entering Action Group [goToHomePageAgain] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePageAgain
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePageAgain
		$I->comment("Exiting Action Group [goToHomePageAgain] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefrontAgain] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createConfigurableProduct', 'name', 'test')); // stepKey: fillInputSearchStorefrontAgain
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefrontAgain
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefrontAgain
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefrontAgain
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefrontAgain
		$I->see("Search results for: '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefrontAgain
		$I->comment("Exiting Action Group [searchStorefrontAgain] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [dontSeeProductAnymore] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
		$I->dontSee($I->retrieveEntityField('createConfigurableProduct', 'name', 'test'), ".column.main"); // stepKey: dontSeeProductNameDontSeeProductAnymore
		$I->comment("Exiting Action Group [dontSeeProductAnymore] StorefrontQuickSearchCheckProductNameNotInGridActionGroup");
	}
}
