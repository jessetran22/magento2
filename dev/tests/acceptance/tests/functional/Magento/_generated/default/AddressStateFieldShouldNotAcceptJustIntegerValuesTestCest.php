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
 * @Title("MC-6223: Guest Checkout - address State field should not allow just integer values")
 * @Description("Address State field should not allow just integer values<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/AddressStateFieldShouldNotAcceptJustIntegerValuesTest.xml<br>")
 * @TestCaseId("MC-6223")
 * @group checkout
 */
class AddressStateFieldShouldNotAcceptJustIntegerValuesTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Checkout"})
	 * @Stories({"MAGETWO-91465"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AddressStateFieldShouldNotAcceptJustIntegerValuesTest(AcceptanceTester $I)
	{
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("Entering Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectCounty
		$I->waitForPageLoad(30); // stepKey: waitFormToReload
		$I->fillField("input[name=region]", "1"); // stepKey: enterStateAsIntegerValue
		$I->waitForPageLoad(30); // stepKey: waitforFormValidation
		$I->see("First character must be letter."); // stepKey: seeTheErrorMessageDisplayed
		$I->fillField("input[name=region]", " 1"); // stepKey: enterStateAsIntegerValue1
		$I->waitForPageLoad(30); // stepKey: waitforFormValidation1
		$I->see("First character must be letter."); // stepKey: seeTheErrorMessageDisplayed1
		$I->fillField("input[name=region]", "ABC1"); // stepKey: enterStateAsIntegerValue2
		$I->waitForPageLoad(30); // stepKey: waitforFormValidation2
		$I->dontSee("First character must be letter."); // stepKey: seeTheErrorMessageIsNotDisplayed
	}
}
