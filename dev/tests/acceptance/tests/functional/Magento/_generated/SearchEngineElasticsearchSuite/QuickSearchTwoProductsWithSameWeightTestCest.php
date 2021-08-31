<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-14796: Quick Search should sort products with the same weight appropriately")
 * @Description("Use Quick Search to find a two products with the same weight<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/SearchEntityResultsTest/QuickSearchTwoProductsWithSameWeightTest.xml<br>")
 * @TestCaseId("MC-14796")
 * @group CatalogSearch
 * @group SearchEngineElasticsearch
 * @group mtf_migrated
 */
class QuickSearchTwoProductsWithSameWeightTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("product1", "hook", "productAlphabeticalA", ["createCategory"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "productAlphabeticalB", ["createCategory"], []); // stepKey: product2
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Create and Assign Attribute to product1");
		$I->comment("Entering Action Group [goToProduct1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('product1', 'id', 'hook')); // stepKey: goToProductGoToProduct1
		$I->comment("Exiting Action Group [goToProduct1] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [createProduct1Attribute] AdminCreateAttributeWithSearchWeightActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnCreateProduct1Attribute
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnCreateProduct1AttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSidePanelCreateProduct1Attribute
		$I->see("Select Attribute"); // stepKey: checkNewAttributePopUpAppearedCreateProduct1Attribute
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeCreateProduct1Attribute
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeCreateProduct1AttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label[0]']", $I->retrieveEntityField('product1', 'name', 'hook')); // stepKey: fillAttributeLabelCreateProduct1Attribute
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelCreateProduct1AttributeWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Text Field"); // stepKey: selectAttributeTypeCreateProduct1Attribute
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeCreateProduct1AttributeWaitForPageLoad
		$I->click("div[data-index='advanced_fieldset']"); // stepKey: openAdvancedSectionCreateProduct1Attribute
		$I->fillField("input[name='default_value_text']", "testProductName" . msq("_defaultProduct")); // stepKey: inputDefaultCreateProduct1Attribute
		$I->click("div[data-index='front_fieldset']"); // stepKey: openStorefrontSectionCreateProduct1Attribute
		$I->checkOption("div[data-index='is_searchable'] .admin__field-control label"); // stepKey: checkUseInSearchCreateProduct1Attribute
		$I->waitForElementVisible("select[name='search_weight']", 30); // stepKey: waitForSearchWeightCreateProduct1Attribute
		$I->selectOption("select[name='search_weight']", "1"); // stepKey: selectWeightCreateProduct1Attribute
		$I->click("button#saveInNewSet"); // stepKey: saveAttributeCreateProduct1Attribute
		$I->waitForPageLoad(10); // stepKey: saveAttributeCreateProduct1AttributeWaitForPageLoad
		$I->fillField("//div[contains(@class, 'modal-inner-wrap') and .//*[contains(., 'Enter Name for New Attribute Set')]]//input[contains(@class, 'admin__control-text')]", $I->retrieveEntityField('product1', 'name', 'hook')); // stepKey: fillSetNameCreateProduct1Attribute
		$I->click("//div[contains(@class, 'modal-inner-wrap') and .//*[contains(., 'Enter Name for New Attribute Set')]]//button[contains(@class, 'action-accept')]"); // stepKey: acceptPopupCreateProduct1Attribute
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingToFinishCreateProduct1Attribute
		$I->comment("Product page will hang if there is no reload");
		$I->reloadPage(); // stepKey: reloadPageCreateProduct1Attribute
		$I->waitForPageLoad(30); // stepKey: waitForReloadCreateProduct1Attribute
		$I->comment("Exiting Action Group [createProduct1Attribute] AdminCreateAttributeWithSearchWeightActionGroup");
		$I->comment("Entering Action Group [selectAttributeSet1] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttributeSet1
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('product1', 'name', 'hook')); // stepKey: filterSelectAttributeSet1
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeSet1WaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttributeSet1
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeSet1WaitForPageLoad
		$I->comment("Exiting Action Group [selectAttributeSet1] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("fill in default");
		$I->comment("Entering Action Group [saveProduct1a] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1a
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1a
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1aWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1a
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1aWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1a
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1a
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1a
		$I->comment("Exiting Action Group [saveProduct1a] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [fillDefault1] AdminProductPageFillTextAttributeValueByNameActionGroup");
		$I->click("//div[@data-index='attributes']"); // stepKey: openSectionFillDefault1
		$I->waitForPageLoad(30); // stepKey: openSectionFillDefault1WaitForPageLoad
		$I->fillField("//div[@data-index='attributes']//fieldset[contains(@class, 'admin__field') and .//*[contains(.,'" . $I->retrieveEntityField('product1', 'name', 'hook') . "')]]//input", "testProductName" . msq("_defaultProduct")); // stepKey: fillValueFillDefault1
		$I->comment("Exiting Action Group [fillDefault1] AdminProductPageFillTextAttributeValueByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct1b] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1b
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1b
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1bWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1b
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1bWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1b
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1b
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1b
		$I->comment("Exiting Action Group [saveProduct1b] SaveProductFormActionGroup");
		$I->comment("Create and Assign Attribute to product2");
		$I->comment("Entering Action Group [goToProduct2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('product2', 'id', 'hook')); // stepKey: goToProductGoToProduct2
		$I->comment("Exiting Action Group [goToProduct2] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [createProduct2Attribute] AdminCreateAttributeWithSearchWeightActionGroup");
		$I->click("#addAttribute"); // stepKey: clickAddAttributeBtnCreateProduct2Attribute
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeBtnCreateProduct2AttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSidePanelCreateProduct2Attribute
		$I->see("Select Attribute"); // stepKey: checkNewAttributePopUpAppearedCreateProduct2Attribute
		$I->click("//button[@data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeCreateProduct2Attribute
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeCreateProduct2AttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label[0]']", $I->retrieveEntityField('product2', 'name', 'hook')); // stepKey: fillAttributeLabelCreateProduct2Attribute
		$I->waitForPageLoad(30); // stepKey: fillAttributeLabelCreateProduct2AttributeWaitForPageLoad
		$I->selectOption("//select[@name='frontend_input']", "Text Field"); // stepKey: selectAttributeTypeCreateProduct2Attribute
		$I->waitForPageLoad(30); // stepKey: selectAttributeTypeCreateProduct2AttributeWaitForPageLoad
		$I->click("div[data-index='advanced_fieldset']"); // stepKey: openAdvancedSectionCreateProduct2Attribute
		$I->fillField("input[name='default_value_text']", "testProductName" . msq("_defaultProduct")); // stepKey: inputDefaultCreateProduct2Attribute
		$I->click("div[data-index='front_fieldset']"); // stepKey: openStorefrontSectionCreateProduct2Attribute
		$I->checkOption("div[data-index='is_searchable'] .admin__field-control label"); // stepKey: checkUseInSearchCreateProduct2Attribute
		$I->waitForElementVisible("select[name='search_weight']", 30); // stepKey: waitForSearchWeightCreateProduct2Attribute
		$I->selectOption("select[name='search_weight']", "1"); // stepKey: selectWeightCreateProduct2Attribute
		$I->click("button#saveInNewSet"); // stepKey: saveAttributeCreateProduct2Attribute
		$I->waitForPageLoad(10); // stepKey: saveAttributeCreateProduct2AttributeWaitForPageLoad
		$I->fillField("//div[contains(@class, 'modal-inner-wrap') and .//*[contains(., 'Enter Name for New Attribute Set')]]//input[contains(@class, 'admin__control-text')]", $I->retrieveEntityField('product2', 'name', 'hook')); // stepKey: fillSetNameCreateProduct2Attribute
		$I->click("//div[contains(@class, 'modal-inner-wrap') and .//*[contains(., 'Enter Name for New Attribute Set')]]//button[contains(@class, 'action-accept')]"); // stepKey: acceptPopupCreateProduct2Attribute
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingToFinishCreateProduct2Attribute
		$I->comment("Product page will hang if there is no reload");
		$I->reloadPage(); // stepKey: reloadPageCreateProduct2Attribute
		$I->waitForPageLoad(30); // stepKey: waitForReloadCreateProduct2Attribute
		$I->comment("Exiting Action Group [createProduct2Attribute] AdminCreateAttributeWithSearchWeightActionGroup");
		$I->comment("Entering Action Group [selectAttributeSet2] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttributeSet2
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('product2', 'name', 'hook')); // stepKey: filterSelectAttributeSet2
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeSet2WaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttributeSet2
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeSet2WaitForPageLoad
		$I->comment("Exiting Action Group [selectAttributeSet2] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("Entering Action Group [saveProduct2a] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2a
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2a
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2aWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2a
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2aWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2a
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2a
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2a
		$I->comment("Exiting Action Group [saveProduct2a] SaveProductFormActionGroup");
		$I->comment("fill in default");
		$I->comment("Entering Action Group [fillDefault2] AdminProductPageFillTextAttributeValueByNameActionGroup");
		$I->click("//div[@data-index='attributes']"); // stepKey: openSectionFillDefault2
		$I->waitForPageLoad(30); // stepKey: openSectionFillDefault2WaitForPageLoad
		$I->fillField("//div[@data-index='attributes']//fieldset[contains(@class, 'admin__field') and .//*[contains(.,'" . $I->retrieveEntityField('product2', 'name', 'hook') . "')]]//input", "testProductName" . msq("_defaultProduct")); // stepKey: fillValueFillDefault2
		$I->comment("Exiting Action Group [fillDefault2] AdminProductPageFillTextAttributeValueByNameActionGroup");
		$I->comment("Entering Action Group [saveProduct2b] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2b
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2b
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2bWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2b
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2bWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2b
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2b
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2b
		$I->comment("Exiting Action Group [saveProduct2b] SaveProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	public function QuickSearchTwoProductsWithSameWeightTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "testProductName" . msq("_defaultProduct")); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: 'testProductName" . msq("_defaultProduct") . "'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: 'testProductName" . msq("_defaultProduct") . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertProduct1Position] StorefrontQuickSearchCheckProductNameInGridActionGroup");
		$I->see($I->retrieveEntityField('product1', 'name', 'test'), ".product-items li:nth-child(1) .product-item-info"); // stepKey: seeProductNameAssertProduct1Position
		$I->comment("Exiting Action Group [assertProduct1Position] StorefrontQuickSearchCheckProductNameInGridActionGroup");
		$I->comment("Entering Action Group [assertProduct2Position] StorefrontQuickSearchCheckProductNameInGridActionGroup");
		$I->see($I->retrieveEntityField('product2', 'name', 'test'), ".product-items li:nth-child(2) .product-item-info"); // stepKey: seeProductNameAssertProduct2Position
		$I->comment("Exiting Action Group [assertProduct2Position] StorefrontQuickSearchCheckProductNameInGridActionGroup");
	}
}
